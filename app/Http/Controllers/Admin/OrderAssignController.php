<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request; 

class OrderAssignController extends Controller
{
   public function assign(Request $request, $orderId)
{
    $request->validate([
        'delivery_id' => 'required|exists:users,id'
    ]);

    $order = Order::findOrFail($orderId);

    $order->delivery_partner_id = $request->delivery_id;
    $order->status = 'assigned';
    $order->save();

    return back()->with('success','Order assigned to delivery partner');
}
}
