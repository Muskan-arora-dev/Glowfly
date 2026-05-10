<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Razorpay\Api\Api;

class OrderController extends Controller
{
    // -----------------------------
    // CREATE RAZORPAY ORDER
    // -----------------------------
    public function createRazorpay(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $amount = $request->amount * 100;

        $razorpayOrder = $api->order->create([
            'amount' => $amount,
            'currency' => 'INR',
            'payment_capture' => 1
        ]);

        return response()->json([
            'orderId' => $razorpayOrder['id'],
            'amount' => $request->amount,
            'key' => env('RAZORPAY_KEY')
        ]);
    }


    // -----------------------------
    // VERIFY PAYMENT
    // -----------------------------
    public function verifyPayment(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ]);

            $items = Cart::where('user_id', Auth::id())->with('product')->get();
            $total = $items->sum(fn($i) => $i->product->price * $i->quantity);

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_id' => strtoupper(Str::random(8)),
                'awb_id' => strtoupper(Str::random(10)),
                'name' => $request->name,
                'address' => $request->address,
                'city' => $request->city,
                'phone' => $request->phone,
                'payment_method' => 'online',
                'total' => $total,
                'status' => 'paid',
                'payment_id' => $request->razorpay_payment_id,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            Cart::where('user_id', Auth::id())->delete();

            return response()->json(['success' => true, 'orderId' => $order->id]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Payment Failed']);
        }
    }


    // -----------------------------
    // SHOW CHECKOUT PAGE
    // -----------------------------
    public function showCheckout(Request $request)
    {
        $productId = $request->product_id ?? null;

        if ($productId) {
            $product = Product::findOrFail($productId);
            $total = $product->price;
            $products = collect([$product]);
        } else {
            $items = auth()->user()->carts()->with('product')->get();
            $total = $items->sum(fn($item) => $item->product->price * $item->quantity);
            $products = $items->map(fn($item) => $item->product);
        }

        return view('checkout.checkout', compact('products', 'total', 'productId'));
    }


    // -----------------------------
    // PLACE ORDER (COD + ONLINE)
    // -----------------------------
   public function placeOrder(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string',
        'city' => 'required|string',
        'phone' => 'required|string|max:15',
        'payment_method' => 'required|in:online,cash',
    ]);

    $deliveryCharge = 40; 

    // CASH PAYMENT
    $items = Cart::where('user_id', Auth::id())->with('product')->get();
    $total = $items->sum(fn($i) => $i->product->price * $i->quantity);

    $order = Order::create([
        'user_id' => Auth::id(),
        'order_id' => strtoupper(Str::random(8)),
        'awb_id' => strtoupper(Str::random(10)),
        'name' => $request->name,
        'address' => $request->address,
        'city' => $request->city,
        'phone' => $request->phone,
        'payment_method' => 'cash',
        'total' => $total,
        'status' => 'placed',
        'delivery_charge' => $deliveryCharge, 
    ]);

    foreach ($items as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'price' => $item->product->price,
        ]);
    }

    Cart::where('user_id', Auth::id())->delete();

    return redirect()->route('order.success', $order->id);
}




    // -----------------------------
    // CANCEL ORDER
    // -----------------------------
    public function cancel(Order $order)
    {
        if ($order->user_id != auth()->id()) {
            return redirect()->back()->with('error', 'You are not authorized to cancel this order.');
        }

        if (in_array($order->status, ['shipped', 'delivered', 'cancelled'])) {
            return redirect()->back()->with('error', 'This order cannot be cancelled.');
        }

        $order->status = 'cancelled';
        $order->save();

        return redirect()->back()->with('success', 'Order cancelled successfully.');
    }


    // -----------------------------
    // ORDER SUCCESS PAGE
    // -----------------------------
    public function success(Order $order)
    {
        $order->load('items.product');
        return view('checkout.order_success', compact('order'));
    }


    // -----------------------------
    // TRACK ORDER
    // -----------------------------
    public function track(Order $order)
    {
        $order->load('items.product');
        $status = $order->status;
        $deliveryDate = $order->created_at->addDays(5)->format('D, d M');
        return view('checkout.track_order', compact('order', 'status', 'deliveryDate'));
    }


    // -----------------------------
    // MY ORDERS
    // -----------------------------
    public function myOrders()
    {
        $orders = auth()->user()->orders()
            ->with('items.product')
            ->latest()
            ->get();

        return view('orders.my_orders', compact('orders'));
    }
}
