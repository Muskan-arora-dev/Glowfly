@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#fdf9ef] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-lg space-y-6">

        <h3 class="text-2xl font-semibold text-center text-[#654321]">Admin Login</h3>

        @if(session('error'))
            <p class="text-red-600 text-center">{{ session('error') }}</p>
        @endif

        <form action="{{ route('admin.password.submit') }}" method="POST">
            @csrf

            <input type="email" name="email"
                   value="{{ session('admin_email') }}"
                   class="w-full p-3 border border-gray-300 rounded-lg mb-4" readonly>

            <input type="password" name="password" placeholder="Enter Admin Password"
                   class="w-full p-3 border border-gray-300 rounded-lg mb-4" required>

            <button type="submit"
                class="w-full py-3 bg-[#654321] text-white rounded-lg">
                Login as Admin
            </button>
        </form>

    </div>
</div>
@endsection
