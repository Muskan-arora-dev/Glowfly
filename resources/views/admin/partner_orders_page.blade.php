@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    <!-- Heading -->
    <div class="mb-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-1">{{ $partner->name }} - Orders</h3>
        <p class="text-gray-500">All orders and stats for this delivery partner</p>
    </div>

    <!-- Back Button aligned right with gradient theme -->
    <div class="mb-4 flex justify-end">
        <a href="{{ route('admin.delivery.requests') }}" 
           class="inline-block px-4 py-2 bg-gradient-to-r from-[#4e54c8] to-[#8f94fb] text-white rounded-lg hover:opacity-90 transition">
           &larr; Back
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white shadow rounded p-4 text-center">
            <h6 class="text-gray-500">Total Orders</h6>
            <h3 class="font-bold text-gray-800">{{ $totalOrders }}</h3>
        </div>
        <div class="bg-white shadow rounded p-4 text-center">
            <h6 class="text-gray-500">Completed</h6>
            <h3 class="font-bold text-green-600">{{ $completedOrders }}</h3>
        </div>
        <div class="bg-white shadow rounded p-4 text-center">
            <h6 class="text-gray-500">Pending</h6>
            <h3 class="font-bold text-yellow-600">{{ $pendingOrders }}</h3>
        </div>
        <div class="bg-white shadow rounded p-4 text-center">
            <h6 class="text-gray-500">Total Earning</h6>
            <h3 class="font-bold text-green-800">₹{{ number_format($totalEarning,2) }}</h3>
        </div>
    </div>

    <!-- Orders Table for Large Screens -->
    <div class="overflow-x-auto bg-white rounded-xl shadow-md hidden md:block">
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gradient-to-r from-[#4e54c8] to-[#8f94fb] text-white">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Order ID</th>
                    <th class="px-4 py-2 border">Customer</th>
                    <th class="px-4 py-2 border">City</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Total</th>
                    <th class="px-4 py-2 border">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $index => $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 border">#{{ $order->id }}</td>
                    <td class="px-4 py-2 border">{{ $order->user->name ?? 'Guest' }}</td>
                    <td class="px-4 py-2 border">{{ $order->city ?? '-' }}</td>
                    <td class="px-4 py-2 border">
                        <span class="px-2 py-1 rounded {{ $order->status == 'delivered' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 border">₹{{ number_format($order->total,2) }}</td>
                    <td class="px-4 py-2 border">{{ $order->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-400">No orders found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Orders Cards for Small Screens -->
    <div class="md:hidden space-y-4">
        @forelse($orders as $order)
        <div class="bg-white rounded-xl shadow-md p-4">
            <div class="flex justify-between items-center mb-2">
                <h5 class="font-semibold text-gray-800">Order #{{ $order->id }}</h5>
                <span class="px-2 py-1 rounded {{ $order->status == 'delivered' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <p class="text-gray-600 mb-1">Customer: {{ $order->user->name ?? 'Guest' }}</p>
            <p class="text-gray-600 mb-1">City: {{ $order->city ?? '-' }}</p>
            <p class="text-gray-600 mb-1">Total: ₹{{ number_format($order->total,2) }}</p>
            <p class="text-gray-400 text-sm">Date: {{ $order->created_at->format('d M Y') }}</p>
        </div>
        @empty
        <p class="text-center py-4 text-gray-400">No orders found</p>
        @endforelse
    </div>

</div>
@endsection
