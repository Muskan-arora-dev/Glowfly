@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold text-[#8f94fb] text-white] mb-4">Order Details</h2>

    <div class="bg-[white] shadow rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold mb-2">Order #{{ $order->order_number ?? $order->id }}</h3>
        <p><strong>Customer:</strong> {{ $order->user->name ?? 'Guest' }}</p>
        <p><strong>Email:</strong> {{ $order->user->email ?? 'N/A' }}</p>
        <p><strong>Phone:</strong> {{ $order->phone }}</p>
        <p><strong>Address:</strong> {{ $order->address }}, {{ $order->city }}</p>
        <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
        <p><strong>Status:</strong> 
            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-semibold
                @if($order->status=='delivered') bg-green-100 text-green-800
                @elseif($order->status=='pending') bg-yellow-100 text-yellow-800
                @elseif($order->status=='cancelled') bg-red-100 text-red-800
                @else bg-gray-100 text-gray-800 @endif">
                {{ ucfirst($order->status) }}
            </span>
        </p>
        <p><strong>Order Date:</strong> {{ $order->created_at->format('d M, Y H:i') }}</p>
    </div>

    <h3 class="text-xl font-bold mb-2">Items Ordered</h3>
    <div class="overflow-x-auto bg-[grey] shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-[#4e54c8] to-[#8f94fb] text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Subtotal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Image</th>
                </tr>
            </thead>
            <tbody class="bg-[white] divide-y divide-gray-100">
                @foreach($order->items as $item)
                    <tr class="hover:bg-[blue-50] transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->product->name ?? 'Deleted Product' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹{{ number_format($item->price,2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">₹{{ number_format($item->quantity * $item->price,2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <img src="{{ asset($item->product->image ?? 'images/no-image.png') }}" class="w-16 h-16 object-cover rounded">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 text-right font-semibold text-lg">
        Total: ₹{{ number_format($order->total,2) }}
    </div>

    <a href="{{ route('admin.orders') }}" class="inline-block mt-6 px-4 py-2 bg-gradient-to-r from-[#4e54c8] to-[#8f94fb] text-white text-[grey] rounded hover:bg-[#8a6a52]">Back to Orders</a>
</div>
@endsection
