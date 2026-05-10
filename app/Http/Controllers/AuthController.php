<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    // Show Register Page
    public function showRegister() {
        return view('auth.register');
    }

    // Register User
    public function register(Request $request) {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required'
        ]);

        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);

        return redirect()->route('login.page')->with('success','Registered successfully');
    }

    // Show Login Page
    public function showLogin() {
        return view('auth.login');
    }

    // Send OTP
    public function sendOtp(Request $request) {
        $request->validate([
            'email'=>'required|email'
        ]);

        $user = User::where('email',$request->email)->first();

        if(!$user){
            return back()->with('error','Email not registered');
        }

        $otp = rand(100000,999999);
        $user->update([
            'otp'=>$otp,
            'otp_expires_at'=>Carbon::now()->addMinutes(5)
        ]);

        Mail::raw("Your OTP Code is: $otp", function ($message) use ($user){
            $message->to($user->email)->subject('Your Login OTP');
        });

        return redirect()->route('verify.otp.page')->with('email',$user->email);
    }

    // Show Verify OTP Page
    public function showVerifyOtp() {
        return view('auth.verify');
    }

    // Verify OTP
    public function verifyOtp(Request $request) {
        $request->validate([
            'email'=>'required|email',
            'otp'=>'required'
        ]);

        $user = User::where('email',$request->email)->first();

        if(!$user){
            return back()->with('error','Invalid email');
        }

        if($user->otp != $request->otp){
            return back()->with('error','Incorrect OTP');
        }

        if(Carbon::now()->greaterThan($user->otp_expires_at)){
            return back()->with('error','OTP expired');
        }

        Auth::login($user);

        // remove OTP
        $user->update(['otp'=>null]);

        return redirect()->route('dashboard');
    }
}
