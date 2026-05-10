<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function showEmailForm() {
        return view('auth.login');
    }


   

    public function logout() {
        Auth::logout();
        return redirect('/login')->with('message','Logged out successfully!');
    }
}
