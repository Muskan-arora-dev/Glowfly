@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    <!-- Heading -->
    <div class="mb-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-1">Delivery Partners</h3>
        <p class="text-gray-500">View requests, partners, and stats</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 animate-fade-in">
            {{ session('success') }}
        </div>
    @endif
    <div class="mb-4 flex justify-end items-center">
    <a href="{{ route('admin.delivery.live-tracking') }}" 
       class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
       Live Tracking
    </a>
</div>

    <!-- ================= APPROVED PARTNERS ================= -->
    <h4 class="font-semibold text-gray-700 mb-2">Approved Delivery Partners</h4>

    <div class="overflow-x-auto mb-6 hidden md:block">
        <table class="min-w-full bg-white rounded-xl shadow-md overflow-hidden">
            <thead class="bg-gradient-to-r from-[#4e54c8] to-[#8f94fb] text-white">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($partners as $index => $partner)
                <tr class="hover:bg-gray-50 transition duration-200">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $partner->name }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $partner->email }}</td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.delivery.partner.orders', $partner->id) }}" 
                           class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                           View Orders
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-gray-400">No delivery partners found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    
    <!-- ================= PENDING REQUESTS ================= -->
    <h4 class="font-semibold text-gray-700 mb-2">Pending Delivery Requests</h4>

    <div class="overflow-x-auto mb-6 hidden md:block">
        <table class="min-w-full bg-white rounded-xl shadow-md overflow-hidden">
            <thead class="bg-gradient-to-r from-[#4e54c8] to-[#8f94fb] text-white">
                <tr>
                    <th class="px-6 py-3">#</th>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($pendingRequests as $index => $user)
                <tr class="hover:bg-gray-50 transition duration-200">
                    <td class="px-6 py-4">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $user->name }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                    <td class="px-6 py-4 text-center">
                        <form method="POST" action="{{ route('admin.delivery.approve', $user->id) }}" class="inline">
                            @csrf
                            <button class="px-3 py-1 bg-green-500 text-white rounded-lg hover:bg-green-600">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('admin.delivery.reject', $user->id) }}" class="inline">
                            @csrf
                            <button class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600">Reject</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-gray-400">No pending requests</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- ================= CARDS FOR SMALL SCREENS ================= -->
    <div class="md:hidden space-y-4 mb-6">

        <!-- Pending Requests -->
        @forelse($pendingRequests as $user)
        <div class="bg-yellow-50 rounded-xl shadow-md p-4">
            <div class="flex justify-between items-center mb-2">
                <h5 class="font-semibold text-gray-800">{{ $user->name }}</h5>
            </div>
            <p class="text-gray-600 mb-2">Email: {{ $user->email }}</p>
            <div class="flex gap-2">
                <form method="POST" action="{{ route('admin.delivery.approve', $user->id) }}" class="flex-1">
                    @csrf
                    <button class="w-full px-3 py-2 bg-green-500 text-white rounded-lg">Approve</button>
                </form>
                <form method="POST" action="{{ route('admin.delivery.reject', $user->id) }}" class="flex-1">
                    @csrf
                    <button class="w-full px-3 py-2 bg-red-500 text-white rounded-lg">Reject</button>
                </form>
            </div>
        </div>
        @empty
        <p class="text-center py-6 text-gray-400">No pending requests</p>
        @endforelse

        <!-- Approved Partners -->
        @forelse($partners as $partner)
        @php
            $orders = $partner->orders ?? collect();
            $completed = $orders->where('status','delivered')->count();
            $pending = $orders->whereIn('status',['pending','assigned','picked'])->count();
            $totalEarning = $orders->where('status','delivered')->sum('total');
            $deliveryCharges = $orders->where('status','delivered')->sum('delivery_charge');
            $grandTotal = $totalEarning + $deliveryCharges;
        @endphp
        <div class="bg-white rounded-xl shadow-md p-4">
            <div class="flex justify-between items-center mb-2">
                <h5 class="font-semibold text-gray-800">{{ $partner->name }}</h5>
            </div>
            <p class="text-gray-600 mb-2">Email: {{ $partner->email }}</p>
            <div class="text-sm text-gray-700 mb-2">
                Total Orders: {{ $orders->count() }} <br>
                Completed: {{ $completed }} <br>
                Pending: {{ $pending }} <br>
                Total Earning: ₹{{ $totalEarning }} <br>
                Delivery Charges: ₹{{ $deliveryCharges }} <br>
                <strong>Grand Total: ₹{{ $grandTotal }}</strong>
            </div>
            <a href="{{ route('admin.delivery.partner.orders', $partner->id) }}" 
               class="w-full block px-3 py-2 bg-blue-500 text-white rounded-lg text-center">View Orders</a>
        </div>
        @empty
        <p class="text-center py-6 text-gray-400">No delivery partners found</p>
        @endforelse

    </div>

</div>
@endsection
