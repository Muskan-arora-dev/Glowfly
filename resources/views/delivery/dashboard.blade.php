@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#f6f4f1] p-4 md:p-6">

    <!-- TITLE -->
    <h2 class="text-3xl font-bold text-center mb-8 text-[#654321]">
        🚚 Delivery Partner Dashboard
    </h2>

    <!-- ONLINE / OFFLINE BUTTON -->
    <div class="flex justify-end mb-8">
        <form action="{{ route('delivery.toggleStatus') }}" method="POST">
            @csrf
            <button class="px-6 py-2 rounded-full font-semibold shadow-lg
                {{ auth()->user()->is_online ? 'bg-[#654321] text-white shadow-[#654321]/50' : 'bg-gray-300 text-gray-800 shadow-gray-400' }}">
                {{ auth()->user()->is_online ? '🟢 Online' : '🔴 Offline' }}
            </button>
        </form>
    </div>

    <!-- STATS CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-[#654321]">
            <p class="text-gray-500 text-sm mb-2">Total Orders</p>
            <p class="text-2xl font-bold text-[#654321]">{{ $totalOrdersCount }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-[#7a4d32]">
            <p class="text-gray-500 text-sm mb-2">Active Orders</p>
            <p class="text-2xl font-bold text-[#7a4d32]">{{ $activeOrdersCount }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-[#8c5c44]">
            <p class="text-gray-500 text-sm mb-2">Completed Orders</p>
            <p class="text-2xl font-bold text-[#8c5c44]">{{ $completedOrdersCount }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg border-l-4 border-[#996655]">
            <p class="text-gray-500 text-sm mb-2">Total Earnings</p>
            <p class="text-2xl font-bold text-[#996655]">₹ {{ $totalEarning ?? 0 }}</p>
        </div>

    </div>

    <!-- ORDERS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        @forelse($orders as $order)
        <div class="bg-white rounded-2xl shadow-lg p-5 border-t-4 border-[#654321]">

            <div class="flex justify-between mb-3">
                <h3 class="font-semibold text-lg text-[#654321]">Order #{{ $order->id }}</h3>
                <span class="text-sm text-gray-500">{{ ucfirst(str_replace('_',' ',$order->status)) }}</span>
            </div>

            <p class="text-sm mb-1"><b>Name:</b> {{ $order->name }}</p>
            <p class="text-sm mb-1"><b>Phone:</b> {{ $order->phone }}</p>
            <p class="text-sm mb-1"><b>Address:</b> {{ $order->address }}</p>
            <p class="text-sm mb-3"><b>Delivery Charge:</b> ₹{{ $order->delivery_charge ?? 0 }}</p>

            {{-- ACCEPT ORDER --}}
            @if(!$order->delivery_partner_id && auth()->user()->is_online)
            <form method="POST" action="{{ route('delivery.order.accept', $order->id) }}" class="mt-2">
                @csrf
                <button class="w-full bg-[#654321] text-white py-2 rounded-lg hover:bg-[#7a4d32] transition shadow-[#654321]/50">
                    Accept Order
                </button>
            </form>

            {{-- OTP VERIFY --}}
            @elseif($order->status === 'on_the_way' && !$order->otp_verified)
            <form method="POST" action="{{ route('delivery.updateStatus', $order->id) }}" class="mt-2">
                @csrf
                <input type="hidden" name="status" value="delivered">
                <input type="text" name="otp" required placeholder="Enter OTP"
                    class="border rounded-lg p-2 w-full mb-2">
                <button class="w-full bg-[#654321] text-white py-2 rounded-lg hover:bg-[#7a4d32] transition shadow-[#654321]/50">
                    Verify OTP & Deliver
                </button>
            </form>

            {{-- STATUS DROPDOWN --}}
            @elseif($order->delivery_partner_id && $order->status !== 'delivered')
            <form method="POST" action="{{ route('delivery.updateStatus', $order->id) }}" class="mt-2">
                @csrf
                <select name="status" class="border rounded-lg p-2 w-full mb-2">
                    <option value="picked" {{ $order->status=='picked'?'selected':'' }}>Picked</option>
                    <option value="on_the_way" {{ $order->status=='on_the_way'?'selected':'' }}>On The Way</option>
                </select>
                <button class="w-full bg-[#654321] text-white py-2 rounded-lg hover:bg-[#7a4d32] transition shadow-[#654321]/50">
                    Update Status
                </button>
            </form>
            @endif

        </div>
        @empty
        <p class="col-span-4 text-center text-gray-500 mt-6">No orders available.</p>
        @endforelse

    </div>
</div>
@endsection
