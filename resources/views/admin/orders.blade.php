@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <h2 class="text-2xl font-bold text-[grey] mb-4">Orders</h2>

    @if($orders->count() > 0)

    <!-- ================= DESKTOP / TABLET TABLE ================= -->
    <div class="hidden md:block bg-[#fdf9ef] shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-[#4e54c8] to-[#8f94fb] text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Order #</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium uppercase">Actions</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-100">
                @foreach($orders as $order)
                @php $status = strtolower($order->status ?? 'unknown'); @endphp
                <tr class="hover:bg-blue-50 hover:text-blue-600 transition">
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $order->order_number ?? $order->id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $order->user->name ?? 'Guest' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ $order->created_at->format('d M, Y H:i') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        ₹{{ number_format($order->total,2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 rounded text-xs font-semibold
                        @if($status==='delivered') bg-green-100 text-green-800
                        @elseif($status==='pending') bg-yellow-100 text-yellow-800
                        @elseif($status==='cancelled') bg-red-100 text-red-800
                        @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap space-y-2">

    <a href="{{ route('admin.orders.show', $order->id) }}"
       class="text-blue-600 hover:text-blue-800 block">
        View
    </a>

    @if(is_null($order->delivery_partner_id))
        <form action="{{ route('admin.order.assign', $order->id) }}" method="POST" class="flex gap-2 mt-1">
            @csrf

            <select name="delivery_id"
                    class="border rounded px-2 py-1 text-sm"
                    required>
                <option value="">Assign Partner</option>
                @foreach($deliveryPartners as $partner)
                    <option value="{{ $partner->id }}">
                        {{ $partner->name }}
                    </option>
                @endforeach
            </select>

            <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                Assign
            </button>
        </form>
    @else
        <span class="inline-block text-xs bg-green-100 text-green-800 px-2 py-1 rounded">
            Assigned
        </span>
    @endif

</td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- ================= MOBILE CARD VIEW ================= -->
    <div class="md:hidden space-y-4">
        @foreach($orders as $order)
        @php $status = strtolower($order->status ?? 'unknown'); @endphp

        <div class="bg-white shadow rounded-lg border border-gray-100 p-4">
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-semibold text-gray-600">
                    Order #{{ $order->order_number ?? $order->id }}
                </span>

                <span class="px-2 py-1 rounded text-xs font-semibold
                @if($status==='delivered') bg-green-100 text-green-800
                @elseif($status==='pending') bg-yellow-100 text-yellow-800
                @elseif($status==='cancelled') bg-red-100 text-red-800
                @else bg-gray-100 text-gray-800 @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            <div class="text-sm text-gray-600 mb-1">
                <strong>Customer:</strong> {{ $order->user->name ?? 'Guest' }}
            </div>

            <div class="text-sm text-gray-600 mb-1">
                <strong>Date:</strong> {{ $order->created_at->format('d M, Y H:i') }}
            </div>

            <div class="flex justify-between items-center mt-3">
                <span class="font-semibold text-gray-800">
                    ₹{{ number_format($order->total,2) }}
                </span>

                <a href="{{ route('admin.orders.show', $order->id) }}"
                   class="text-blue-600 font-semibold hover:text-blue-800">
                    View
                </a>
            </div>
        </div>

        @endforeach
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>

    @else
    <div class="text-center p-6 bg-[#f7f2ea] rounded-lg">
        No orders found.
    </div>
    @endif
</div>
@endsection
