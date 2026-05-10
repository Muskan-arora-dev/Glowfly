<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Mail\SupplierCredentials;

class AdminSupplierController extends Controller
{
    // ----------------- Add Supplier -----------------
    public function createSupplier(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        $username = $request->email;
        $password = Str::random(8);

        $supplier = User::create([
            'name'           => $request->name,
            'username'       => $username,
            'email'          => $request->email,
            'password'       => Hash::make($password),
            'role'           => 'supplier',
            'wallet_balance' => 0,
        ]);

        Mail::to($supplier->email)
            ->send(new SupplierCredentials($supplier, $username, $password));

        return back()->with(
            'success',
            "Supplier created! Username: {$username}, Password: {$password}"
        );
    }

    // ----------------- Supplier Dashboard -----------------
    public function supplierLoginDashboard()
    {
        $supplier = Auth::user();

        if ($supplier->role !== 'supplier') {
            abort(403);
        }

        $totalProducts = Product::where('supplier_id', $supplier->id)->count();
        $walletBalance = $supplier->wallet_balance ?? 0;

        $categories    = Category::orderBy('name')->get();
        $subcategories = Subcategory::orderBy('name')->get();

        return view('admin.supplier.index', compact(
            'supplier',
            'totalProducts',
            'walletBalance',
            'categories',
            'subcategories'
        ));
    }

    // ----------------- Supplier Add Product -----------------
    public function supplierAddProduct(Request $request)
    {
        $supplier = Auth::user();

        if ($supplier->role !== 'supplier') {
            abort(403);
        }

        $request->validate([
            'name'           => 'required|string|max:255',
            'category_id'    => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
             'price' => 'required|numeric|min:0',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

         $imagePath = 'products/default.png';

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
    }

        
        $slug = Str::slug($request->name) . '-' . time();

        Product::create([
    'name'           => $request->name,
    'slug'           => $slug,
    'category_id'    => $request->category_id,
    'subcategory_id' => $request->subcategory_id,
    'supplier_id'    => $supplier->id,
    'price'          => $request->price,   
    'image'          => $imagePath,
    'status'         => 'pending',
]);


        return back()->with('success', 'Product added successfully');
    }


    public function showSuppliersPanel()
{
    $suppliers = User::where('role', 'supplier')->latest()->get();

    return view('admin.supplier.suppliers_panel', compact('suppliers'));
}

public function supplierDashboard($id)
{
    $supplier = User::where('id', $id)
        ->where('role', 'supplier')
        ->firstOrFail();

    
    $products = Product::where('supplier_id', $supplier->id)
        ->latest()
        ->get();

    
    $pendingProducts = Product::where('supplier_id', $supplier->id)
        ->where('status', 'pending')
        ->get();

    return view('admin.supplier.dashboard', compact(
        'supplier',
        'products',
        'pendingProducts'
    ));
}


// ----------------- Purchase Form -----------------
public function purchaseForm(Product $product)
{
    return view('admin.supplier.form', compact('product'));
}

// ----------------- Purchase Store -----------------


public function purchaseStore(Request $request, Product $product)
{
    $request->validate([
        'quantity' => 'required|integer|min:1',
    ]);

    $admin = auth()->user();           
    $supplier = $product->supplier;   

    $totalAmount = $product->price * $request->quantity;

    
    if ($admin->wallet_balance < $totalAmount) {
        return back()->with('error', 'Insufficient admin wallet balance');
    }

    DB::transaction(function () use ($admin, $supplier, $product, $request, $totalAmount) {

        $admin->wallet_balance -= $totalAmount;
        $supplier->wallet_balance += $totalAmount;

        $admin->save();
        $supplier->save();

        
        $product->quantity = ($product->quantity ?? 0) + $request->quantity;

        $product->status = 'approved';

        $product->save();
    });

    
    return redirect()
        ->route('admin.suppliers.dashboard', $supplier->id)
        ->with('success', '✅ Product purchased successfully & payment transferred!');
}


}
