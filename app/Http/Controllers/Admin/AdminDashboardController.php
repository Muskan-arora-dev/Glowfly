<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\DeliveryApproved;
use App\Mail\DeliveryRejected;

class AdminDashboardController extends Controller
{
    // ---------------- Dashboard ----------------
   public function dashboard()
{
    $totalOrders     = Order::count();
    $deliveredOrders = Order::where('status','delivered')->count();
    $pendingOrders   = Order::where('status','pending')->count();
    $cancelledOrders = Order::where('status','cancelled')->count();

    $totalRevenue    = Order::sum('total');
    $deliveredAmount = Order::where('status','delivered')->sum('total');
    $pendingAmount   = Order::where('status','pending')->sum('total');
    $cancelAmount    = Order::where('status','cancelled')->sum('total');

    $months = collect(range(5, 0))->map(function ($i) {
        return Carbon::now()->subMonths($i)->format('M Y');
    });

    $revenueRaw = Order::select(
            DB::raw("TO_CHAR(created_at, 'Mon YYYY') as month"),
            DB::raw("SUM(total) as revenue")
        )
        ->where('status','delivered')
        ->where('created_at','>=',now()->subMonths(6))
        ->groupBy(DB::raw("TO_CHAR(created_at, 'Mon YYYY')"))
        ->orderBy(DB::raw("MIN(created_at)"))
        ->pluck('revenue','month');

    $ordersRaw = Order::select(
            DB::raw("TO_CHAR(created_at, 'Mon YYYY') as month"),
            DB::raw("COUNT(*) as total")
        )
        ->where('created_at','>=',now()->subMonths(6))
        ->groupBy(DB::raw("TO_CHAR(created_at, 'Mon YYYY')"))
        ->orderBy(DB::raw("MIN(created_at)"))
        ->pluck('total','month');

    $monthlyRevenue = $months->map(fn($m) => (float) ($revenueRaw[$m] ?? 0));
    $monthlyOrders  = $months->map(fn($m) => (int) ($ordersRaw[$m] ?? 0));

    // Add this
    $recentOrders = Order::with('user')->latest()->take(5)->get();

    return view('admin.dashboard', compact(
        'totalOrders','deliveredOrders','pendingOrders','cancelledOrders',
        'totalRevenue','deliveredAmount','pendingAmount','cancelAmount',
        'months','monthlyRevenue','monthlyOrders',
        'recentOrders'
    ));
}
public function partnerOrdersPage($userId)
{
    $partner = User::findOrFail($userId);

    $orders = Order::where('delivery_partner_id', $userId)
                   ->orderBy('created_at','desc')
                   ->get();

    // Stats calculation
    $totalOrders = $orders->count();
    $completedOrders = $orders->where('status','delivered')->count();
    $pendingOrders = $orders->whereIn('status',['pending','assigned','picked'])->count();
     $totalEarning =  $orders->where('status','delivered')->sum('delivery_charge');

    return view('admin.partner_orders_page', compact(
        'partner', 'orders', 'totalOrders', 'completedOrders', 'pendingOrders', 'totalEarning'
    ));
}


    // ---------------- Orders ----------------
    public function orders()
    {
        $orders = Order::latest()->paginate(10);
        $deliveryPartners = User::where('role','delivery')
                                ->where('delivery_status','approved')
                                ->get();

        return view('admin.orders', compact('orders','deliveryPartners'));
    }

    public function showOrder($id)
    {
        $order = Order::with(['user','items.product'])->findOrFail($id);
        return view('admin.order_show', compact('order'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,delivered,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success','Order status updated!');
    }

    // ---------------- Users ----------------
    public function users()
    {
        $users = User::latest()->paginate(4);
        return view('admin.users', compact('users'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:user,admin',
            'status' => 'required|in:active,inactive'
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->status = $request->status;
        $user->save();

        return redirect()->back()->with('success','User updated!');
    }

    // ---------------- Products ----------------
    public function products()
    {
        $products = Product::latest()->paginate(20);
        return view('admin.products', compact('products'));
    }

    public function show($slug)
    {
        $category = Category::with('subcategories.products')->where('slug', $slug)->firstOrFail();
        $products = Product::whereHas('subcategory', function($q) use ($category) {
            $q->where('category_id', $category->id);
        })->paginate(90);

        return view('admin.products', compact('category', 'products'));
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $subcategories = $product->category_id 
                        ? SubCategory::where('category_id', $product->category_id)->get()
                        : collect();

        return view('admin.products.edit', compact('product', 'categories', 'subcategories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $product->name = $request->name;
        $product->price = $request->price;

        if ($request->hasFile('image')) {
            if($product->image && file_exists(public_path($product->image))){
                unlink(public_path($product->image));
            }
            $imageName = time().'_'.$request->image->getClientOriginalName();
            $request->image->move(public_path('images'), $imageName);
            $product->image = 'images/'.$imageName;
        }

        $product->save();
        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        if(file_exists(public_path($product->image))){
            unlink(public_path($product->image));
        }
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
    }

    // ---------------- Payments ----------------
    public function payments()
    {
        $totalPayment = Order::sum('total');
        $successPayment = Order::where('status','delivered')->sum('total');
        $pendingPayment = Order::where('status','pending')->sum('total');
        $failedPayment = Order::where('status','cancelled')->sum('total');

        return view('admin.payments', compact('totalPayment','successPayment','pendingPayment','failedPayment'));
    }

    // ---------------- Delivery Requests ----------------
    public function deliveryRequests()
    {
        $pendingRequests = User::where('role', 'delivery')
                               ->where('delivery_status', 'pending')
                               ->get();

        $partners = User::where('role', 'delivery')
                        ->where('delivery_status', 'approved')
                        ->get();

        return view('admin.delivery_requests', compact('pendingRequests', 'partners'));
    }

    public function approveDelivery($id)
    {
        $user = User::findOrFail($id);
        $user->delivery_status = 'approved';
        $user->save();

        Mail::to($user->email)->send(new DeliveryApproved($user));

        return back()->with('success','Delivery partner approved');
    }

    public function rejectDelivery($id)
    {
        $user = User::findOrFail($id);
        $user->delivery_status = 'rejected';
        $user->save();

        Mail::to($user->email)->send(new DeliveryRejected($user));

        return back()->with('success','Delivery partner rejected');
    }

    // ---------------- Delivery Partner Orders ----------------
    public function deliveryPartners()
    {
        $partners = User::where('role','delivery')->get();

        $pendingRequests = User::where('role','delivery')
                                ->where('delivery_status','pending')
                                ->get();

        return view('admin.delivery_partners', compact('partners','pendingRequests'));
    }

    public function partnerOrders($userId)
    {
        $orders = Order::where('delivery_partner_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        $totalOrders     = $orders->count();
        $completedOrders = $orders->where('status', 'delivered')->count();
        $pendingOrders   = $orders->whereIn('status', ['pending','assigned','picked'])->count();
        $totalEarning    = $orders->where('status','delivered')->sum('total');

        $ordersHtml = view('admin.delivery_partner_orders', compact('orders'))->render();

        return response()->json([
            'total_orders'     => $totalOrders,
            'completed_orders' => $completedOrders,
            'pending_orders'   => $pendingOrders,
            'total_earning'    => number_format($totalEarning,2),
            'orders_html'      => $ordersHtml,
        ]);
    }

   public function liveTracking()
{
    $partners = User::where('role', 'delivery')
        ->where('delivery_status', 'approved')
        ->with([
            'orders' => function ($q) {
                $q->whereIn('status', [
                    'pending',
                    'assigned',
                    'picked',
                    'delivered'
                ])->with('user');
            }
        ])
        ->get();

    return view('admin.delivery_live_tracking', compact('partners'));
}

public function supplierPendingProducts()
{
    $products = Product::where('status', 'pending')->with('supplier')->get();

    return view('admin.supplier.pending_products', compact('products'));
}
public function approveProduct($id)
{
    $admin = auth()->user();
    $product = Product::findOrFail($id);
    $supplier = $product->supplier;

    $totalAmount = $product->price * $product->quantity;

    if ($admin->wallet_balance < $totalAmount) {
        return back()->with('error', 'Admin wallet balance insufficient');
    }

    // Wallet transfer
    $admin->decrement('wallet_balance', $totalAmount);
    $supplier->increment('wallet_balance', $totalAmount);

    // Approve product
    $product->update([
        'status' => 'approved'
    ]);

    return back()->with('success', 'Product approved & published');
}


}
