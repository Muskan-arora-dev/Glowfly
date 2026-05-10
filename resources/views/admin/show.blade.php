@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h2 class="text-3xl font-bold text-[#654321] mb-6">User Details</h2>

    <div class="bg-[#fdf9ef] p-6 rounded-xl shadow-lg max-w-xl mx-auto">
        <div class="mb-4">
            <strong class="text-[#654321]">Name:</strong>
            <span class="text-black">{{ $user->name }}</span>
        </div>
        <div class="mb-4">
            <strong class="text-[#654321]">Email:</strong>
            <span class="text-black">{{ $user->email }}</span>
        </div>
        <div class="mb-4">
            <strong class="text-[#654321]">Status:</strong>
            <span class="text-black">{{ ucfirst($user->status ?? 'active') }}</span>
        </div>
        <div class="mb-4">
            <strong class="text-[#654321]">Joined At:</strong>
            <span class="text-black">{{ $user->created_at->format('d M, Y h:i A') }}</span>
        </div>

        <a href="{{ route('admin.users.index') }}" 
           class="px-4 py-2 bg-[#654321] text-[#fdf9ef] rounded hover:bg-[#543210] transition">Back to Users</a>
    </div>
</div>
@endsection
