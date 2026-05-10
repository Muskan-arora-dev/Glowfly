<?php
namespace App\Http\Controllers\Delivery;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\WalletWithdraw;

class WalletController extends Controller
{
    public function index()
    {
        $withdraws = WalletWithdraw::where('user_id',Auth::id())->latest()->get();
        return view('delivery.wallet', compact('withdraws'));
    }

    public function withdraw()
    {
        $user = Auth::user();

        request()->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        if(request('amount') > $user->wallet_balance){
            return back()->with('error','Insufficient balance');
        }

        WalletWithdraw::create([
            'user_id' => $user->id,
            'amount' => request('amount'),
        ]);

        return back()->with('success','Withdraw request sent to admin');
    }
}
