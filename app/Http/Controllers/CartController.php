<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Add product to cart
    public function add($productId)
    {
        $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        return back()->with('success', 'Added to cart!');
    }

    // Show cart
    public function show()
    {
        $items = Cart::where('user_id', Auth::id())
                    ->with('product')
                    ->get();

        $recommended = collect();

        if ($items->count() > 0) {
            $subIds = $items->pluck('product.subcategory_id');
            $recommended = Product::whereIn('subcategory_id', $subIds)
                            ->whereNotIn('id', $items->pluck('product_id'))
                            ->limit(3)
                            ->get();
        }

        return view('cart.show', compact('items', 'recommended'));
    }

    // Remove item
    public function remove($id)
    {
        Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success', 'Item removed from cart!');
    }

    // Update quantity
    public function updateQty(Request $request, $id)
    {
        $cart = Cart::find($id);

        if ($request->action == 'increase') {
            $cart->quantity += 1;
        } else {
            if ($cart->quantity > 1) {
                $cart->quantity -= 1;
            }
        }

        $cart->save();
        return back();
    }

    // Buy All Cart Items
    public function buyAll(Request $request)
    {
        $items = Cart::where('user_id', Auth::id())->with('product')->get();

        if($items->isEmpty()) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        $total = $items->sum(fn($i) => $i->product->price * $i->quantity);

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_id' => strtoupper(Str::random(8)),
            'awb_id' => strtoupper(Str::random(10)),
            'name' => Auth::user()->name,
            'address' => Auth::user()->address ?? 'Not provided',
            'city' => Auth::user()->city ?? 'Not provided',
            'phone' => Auth::user()->phone ?? 'Not provided',
            'payment_method' => 'cash',
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

        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('order.success', $order->id);
    }

    // Buy Now single product
   public function buyNow($productId)
{
    $product = Product::findOrFail($productId);

    // Clear previous temporary cart (optional)
    Cart::where('user_id', auth()->id())->delete();

    // Add only this product to cart
    Cart::create([
        'user_id' => auth()->id(),
        'product_id' => $product->id,
        'quantity' => 1
    ]);

    // Redirect to checkout page
    return redirect()->route('checkout.show');
}
}


