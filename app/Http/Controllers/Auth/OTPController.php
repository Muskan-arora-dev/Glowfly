<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class OTPController extends Controller
{
    // ================= REGISTER =================
    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required'
        ]);

        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>'user'
        ]);

        return redirect()->route('login.page')->with('success','Registered successfully');
    }

    // ================= LOGIN PAGE =================
    public function showLogin() {
        return view('auth.login');
    }

    // ================= SEND OTP / REDIRECT =================
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email not registered');
        }

        // 🔥 ADMIN → PASSWORD LOGIN
        if ($user->is_admin == 1) {
            return redirect()
                ->route('admin.password.login')
                ->with('admin_email', $user->email);
        }

        // 🔥 SUPPLIER → PASSWORD LOGIN
    
        if ($user->role === 'supplier') {
            session(['supplier_email' => $user->email]); 
            return redirect()->route('supplier.password.login');
        }

        // 🔥 NORMAL USER → OTP LOGIN
        $otp = rand(100000, 999999);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5)
        ]);

        Mail::raw("Your OTP Code is: $otp", function ($message) use ($user) {
            $message->to($user->email)->subject('Your Login OTP');
        });

        return redirect()->route('verify.otp.page')->with('email', $user->email);
    }

    // ================= ADMIN PASSWORD LOGIN =================
    public function showAdminPasswordForm()
    {
        return view('auth.admin_password_login')
            ->with('admin_email', session('admin_email'));
    }

    public function adminPasswordLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)
                    ->where('is_admin', 1)
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid Admin Credentials');
        }

        Auth::login($user);
        return redirect()->route('admin.dashboard');
    }

    // ================= SUPPLIER PASSWORD LOGIN =================
    public function showSupplierPasswordForm()
    {
        return view('auth.supplier_password_login')
            ->with('supplier_email', session('supplier_email'));
    }

    public function supplierPasswordLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)
                    ->where('role', 'supplier')
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid Supplier Credentials');
        }

        Auth::login($user);
       return redirect()->route('admin.supplier.index');

    }

    // ================= OTP VERIFY =================
    public function showVerifyOtp() {
        return view('auth.verify');
    }

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
        $user->update(['otp'=>null]);

        return redirect()->route('welcome');
    }
}
