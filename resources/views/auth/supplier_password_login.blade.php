@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-20 max-w-md">

    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4 text-center text-gray-800">Supplier Login</h2>
        <p class="text-gray-500 mb-6 text-center">Login with your email and password</p>

        @if(session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

       <form action="{{ route('supplier.password.submit') }}" method="POST">
    @csrf
    <div class="mb-4">
        <label class="block mb-1 font-semibold">Email</label>
<input type="email" name="email" value="{{ session('supplier_email') ?? old('email') }}" class="w-full border rounded px-3 py-2" readonly>
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Password</label>
        <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
    </div>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Login</button>
</form>

    </div>

</div>
@endsection
