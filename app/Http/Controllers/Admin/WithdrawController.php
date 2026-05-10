<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WalletWithdraw;
use App\Models\User;

class WithdrawController extends Controller
{
    public function requests()
    {
        $requests = WalletWithdraw::with('user')->latest()->get();
        return view('admin.withdraw_requests', compact('requests'));
    }

    public function approve($id)
    {
        $w = WalletWithdraw::findOrFail($id);
        $user = User::find($w->user_id);

        if($user->wallet_balance < $w->amount){
            return back()->with('error','Insufficient balance');
        }

        $user->decrement('wallet_balance', $w->amount);
        $w->update(['status'=>'approved']);

        return back()->with('success','Withdraw approved');
    }

    public function reject($id)
    {
        WalletWithdraw::findOrFail($id)->update(['status'=>'rejected']);
        return back()->with('success','Withdraw rejected');
    }
}
