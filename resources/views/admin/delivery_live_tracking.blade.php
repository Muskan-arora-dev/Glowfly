@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <h3 class="text-2xl font-bold text-gray-800 mb-6">🚚 Live Delivery Tracking</h3>

    @forelse($partners as $partner)

    @php
        $activeOrders = $partner->orders->whereIn('status',['pending','assigned','picked']);
        $completedOrders = $partner->orders->where('status','delivered');

        $totalOrders = $partner->orders->count();
        $activeCount = $activeOrders->count();
        $completedCount = $completedOrders->count();

        $totalEarning = $completedOrders->sum('delivery_charge');
    @endphp

    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8">

        <!-- ================= PARTNER HEADER ================= -->
        <div class="flex justify-between items-center mb-4">
            <div>
                <h4 class="text-xl font-semibold text-gray-800">{{ $partner->name }}</h4>
                <p class="text-gray-500 text-sm">{{ $partner->email }}</p>
            </div>
            <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 font-semibold">
                Active
            </span>
        </div>

        <!-- ================= STATS CARDS ================= -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">

            <div class="bg-blue-50 p-4 rounded-xl text-center">
                <p class="text-sm text-gray-600">Total Orders</p>
                <p class="text-xl font-bold text-blue-700">{{ $totalOrders }}</p>
            </div>

            <div class="bg-yellow-50 p-4 rounded-xl text-center">
                <p class="text-sm text-gray-600">Active Orders</p>
                <p class="text-xl font-bold text-yellow-700">{{ $activeCount }}</p>
            </div>

            <div class="bg-green-50 p-4 rounded-xl text-center">
                <p class="text-sm text-gray-600">Completed Orders</p>
                <p class="text-xl font-bold text-green-700">{{ $completedCount }}</p>
            </div>

            <div class="bg-purple-50 p-4 rounded-xl text-center">
                <p class="text-sm text-gray-600">Total Earning</p>
                <p class="text-xl font-bold text-purple-700">₹{{ number_format($totalEarning,2) }}</p>
            </div>

        </div>

        <!-- ================= ACTIVE ORDERS ================= -->
        <h5 class="font-semibold text-gray-700 mb-3">📦 Active Orders</h5>

        @if($activeOrders->isEmpty())
            <p class="text-gray-400">No active orders</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($activeOrders as $order)
                <div class="border rounded-xl p-4 shadow-sm bg-gray-50">

                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold text-gray-800">Order #{{ $order->id }}</span>
                        <span class="px-2 py-1 rounded text-xs 
                            {{ $order->status == 'picked' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <p class="text-sm text-gray-600 mb-1">
                        <strong>Customer:</strong> {{ $order->user->name ?? 'Guest' }}
                    </p>

                    <p class="text-sm text-gray-600 mb-1">
                        <strong>City:</strong> {{ $order->city ?? '-' }}
                    </p>

                    <p class="text-sm text-gray-600 mb-1">
                        <strong>Address:</strong> {{ $order->address ?? '-' }}
                    </p>

                    <div class="flex justify-between items-center mt-3">
                        <span class="text-sm font-semibold text-gray-700">
                            Delivery Charge: ₹{{ $order->delivery_charge ?? 0 }}
                        </span>
                        <span class="text-sm font-bold text-green-700">
                            Total: ₹{{ $order->total }}
                        </span>
                    </div>

                </div>
                @endforeach
            </div>
        @endif

    </div>

    @empty
        <p class="text-center py-6 text-gray-400">No delivery partners found</p>
    @endforelse
</div>
@endsection
