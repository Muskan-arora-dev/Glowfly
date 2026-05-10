<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    // -----------------------------
    // CREATE RAZORPAY ORDER
    // -----------------------------
    public function createOrder(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $amount = $request->amount * 100; // paise me convert

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
    // VERIFY ONLINE PAYMENT
    // -----------------------------
    public function verifyPayment(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature
        ];

        try {
            // Signature verify karna
            $api->utility->verifyPaymentSignature($attributes);

            // Cart items
            $items = Cart::where('user_id', Auth::id())->with('product')->get();
            if ($items->isEmpty()) {
                return response()->json(['success' => false, 'message' => 'Cart is empty']);
            }

            // Total calculate
            $total = $items->sum(fn($i) => $i->product->price * $i->quantity);

            // Create online order
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
                'status' => 'Paid',
            ]);

            // Create order items
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);
            }

            // Clear cart
            Cart::where('user_id', Auth::id())->delete();

            return response()->json(['success' => true, 'orderId' => $order->id]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // -----------------------------
    // PLACE COD ORDER
    // -----------------------------
    public function placeCOD(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'phone' => 'required|string|max:15',
        ]);

        $items = Cart::where('user_id', Auth::id())->with('product')->get();
        if ($items->isEmpty()) {
            return redirect()->back()->with('error', 'Cart is empty');
        }

        $total = $items->sum(fn($i) => $i->product->price * $i->quantity);

        // Create COD order
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
            'status' => 'Placed',
        ]);

        // Create order items
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price
            ]);
        }

        // Clear cart
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('checkout.order_success', $order->id);
    }
}
