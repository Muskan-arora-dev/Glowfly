<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\DeliveryOtpMail;

class DeliveryDashboardController extends Controller
{
    // ================= Dashboard =================
    public function dashboard()
    {
        $deliveryId = Auth::id();

        $openOrders = Order::whereNull('delivery_partner_id')
            ->where('status', 'placed')
            ->latest()
            ->get();

        $newOrders = Order::where('delivery_partner_id', $deliveryId)
            ->where('status', 'assigned')
            ->get();

        $activeOrders = Order::where('delivery_partner_id', $deliveryId)
            ->whereIn('status', ['picked', 'on_the_way'])
            ->get();

        $completedOrders = Order::where('delivery_partner_id', $deliveryId)
            ->where('status', 'delivered')
            ->get();

        // ✅ COUNTS
        $activeOrdersCount = $activeOrders->count();
        $completedOrdersCount = $completedOrders->count();
        $totalOrdersCount =
            $newOrders->count() + $activeOrdersCount + $completedOrdersCount;

        // ✅ TOTAL EARNING (IMPORTANT)
        $totalEarning = $completedOrders->sum('delivery_charge');

        // ✅ MERGED ORDERS (for blade loop)
        $orders = $openOrders
            ->merge($newOrders)
            ->merge($activeOrders)
            ->merge($completedOrders);

        return view('delivery.dashboard', compact(
            'orders',
            'openOrders',
            'newOrders',
            'activeOrders',
            'completedOrders',
            'activeOrdersCount',
            'completedOrdersCount',
            'totalOrdersCount',
            'totalEarning'
        ));
    }

    // ================= Accept Order =================
    public function acceptOrder($id)
    {
        $order = Order::where('id', $id)
            ->whereNull('delivery_partner_id')
            ->where('status', 'placed')
            ->firstOrFail();

        $order->update([
            'delivery_partner_id' => Auth::id(),
            'status' => 'assigned',
        ]);

        return back()->with('success', 'Order accepted successfully');
    }

    // ================= Update Order Status =================
    public function updateStatus(Request $request, $id)
    {
        $order = Order::where('id', $id)
            ->where('delivery_partner_id', Auth::id())
            ->firstOrFail();

        /* ========= PICKED ========= */
        if ($request->status === 'picked') {
            $order->update(['status' => 'picked']);
            return back()->with('success', 'Order picked');
        }

        /* ========= ON THE WAY (SEND OTP) ========= */
        if ($request->status === 'on_the_way') {

            $otp = rand(100000, 999999);

            $order->update([
                'status' => 'on_the_way',
                'delivery_otp' => $otp,
                'otp_verified' => false,
            ]);

            // 🔥 OTP MAIL (IMPORTANT)
            if ($order->user && $order->user->email) {
                Mail::to($order->user->email)
                    ->send(new DeliveryOtpMail($otp, $order));
            }

            return back()->with('success', 'OTP sent to customer email');
        }

        /* ========= VERIFY OTP & DELIVER ========= */
        if ($request->status === 'delivered') {

            if (!$request->otp) {
                return back()->with('error', 'Please enter OTP');
            }

            if ($request->otp != $order->delivery_otp) {
                return back()->with('error', 'Invalid OTP');
            }

                $order->update([
            'status' => 'delivered',
            'otp_verified' => true,
            'delivery_charge' => 40, 
        ]);


            return back()->with('success', 'Order delivered successfully');
        }

        return back();
    }

    // ================= Toggle Online/Offline =================
    public function toggleStatus()
    {
        $user = Auth::user();
        $user->is_online = !$user->is_online;
        $user->save();

        return back()->with('success', 'Status updated');
    }
}
