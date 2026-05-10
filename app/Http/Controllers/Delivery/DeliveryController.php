<?php

namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use App\Mail\DeliveryRequestSubmitted;
use App\Models\Order;

class DeliveryController extends Controller
{
    // Show apply form
    public function applyForm()
    {
        $user = Auth::user();

        // Already applied
        if ($user->delivery_status == 'pending') {
            return view('delivery.pending');
        }

        // Already approved
        if ($user->delivery_status == 'approved') {
            return redirect()->route('delivery.dashboard');
        }

        // First time apply
        return view('delivery.apply');
    }

    // Submit apply request

public function applySubmit(Request $request)
{
    $user = Auth::user();

    if($user->delivery_status == 'pending' || $user->delivery_status == 'approved') {
        return redirect()->back()->with('alert', '⏳ Your request is under review. Please wait for admin approval.');
    }

    // Set role to delivery
    $user->role = 'delivery';
    $user->delivery_status = 'pending';
    $user->save();

    // Send email
    Mail::to($user->email)->send(new DeliveryRequestSubmitted($user));

    return redirect()->back()->with('alert', '✅ Delivery partner request submitted successfully! Check your email.');
}

public function cancelRequest()
{
    $user = Auth::user();
    $user->delivery_status = null; // reset status
    $user->role = 'user';           // revert role
    $user->save();

    return redirect()->route('home')->with('success', '⏳ Your delivery request has been cancelled.');
}


}
