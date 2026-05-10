@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#fdf9ef] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <h2 class="mt-6 text-4xl font-extrabold text-[#654321]">Glowfly</h2>
            <p class="mt-2 text-sm text-gray-600">Enter the OTP sent to your email</p>
        </div>

        <div class="bg-white p-8 rounded-2xl shadow-lg space-y-6">
            <h3 class="text-2xl font-semibold text-[#654321] text-center">Verify OTP</h3>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <p class="text-green-600 text-center">{{ session('success') }}</p>
            @endif
            @if(session('error'))
                <p class="text-red-600 text-center">{{ session('error') }}</p>
            @endif

            <!-- OTP Verification Form -->
            <form action="{{ route('verify.otp') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="email" value="{{ session('email') }}">

                <input type="number" name="otp" placeholder="Enter OTP" required
                       class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#654321]">

                <button type="submit"
                        class="w-full py-3 bg-[#654321] text-white font-semibold rounded-lg hover:bg-[#4b2f1f] transition duration-300">
                    Verify OTP
                </button>
            </form>

            <!-- Back to Login -->
            <div class="text-center mt-4">
                <a href="{{ route('login.page') }}"
                   class="text-[#654321] hover:text-[#4b2f1f] font-medium underline">
                    Back to Login
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
