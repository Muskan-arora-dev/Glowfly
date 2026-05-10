<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Cart; 
use Illuminate\Http\Request;
use App\Models\OrderItem;
use Illuminate\Support\Str;



class CheckoutController extends Controller
{
   public function show()
{
    $items = Cart::where('user_id', auth()->id())->with('product')->get();
$total = $items->sum(fn($i) => $i->product->price * $i->quantity);

// Agar Blade me $products chahiye
$products = $items->pluck('product');

return view('checkout.checkout', compact('items', 'products', 'total'));

}


   public function place(Request $request)
{
    $items = Cart::where('user_id', auth()->id())->with('product')->get();

    if ($items->isEmpty()) {
        return redirect()->back()->with('error', 'Cart is empty');
    }

    $total = $items->sum(fn($i) => $i->product->price * $i->quantity);

    $order = Order::create([
        'user_id' => auth()->id(),
        'order_id' => strtoupper(Str::random(8)),
        'awb_id' => strtoupper(Str::random(10)),
        'name' => auth()->user()->name,
        'address' => auth()->user()->address ?? 'Not provided',
        'city' => auth()->user()->city ?? 'Not provided',
        'phone' => auth()->user()->phone ?? 'Not provided',
        'payment_method' => $request->payment_method ?? 'cash',
        'total' => $total,
        'status' => 'pending',
    ]);
 


    foreach ($items as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'price' => $item->product->price,
        ]);
    }

    Cart::where('user_id', auth()->id())->delete();

    return redirect()->route('checkout.order_success', $order->id);
}


    public function success($orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);

        return view('checkout.order_success', compact('order'));
    }
}
