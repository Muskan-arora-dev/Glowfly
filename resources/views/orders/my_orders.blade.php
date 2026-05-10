@extends('layouts.app')

@section('content')
    
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-[#654321] mb-6">My Orders</h1>

    @if($orders->isEmpty())
        <div class="text-center py-20">
            <p class="text-xl text-[#654321] mb-4 font-semibold">You have no orders yet.</p>
            <a href="{{ route('home') }}" class="px-4 py-2 bg-[#654321] text-[#fdf9ef] rounded hover:bg-[#401d07] transition">
                Continue Shopping
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="border rounded shadow p-4 bg-white relative">
                    <!-- Order Header -->
                    <div class="flex justify-between items-center border-b pb-2 mb-4">
                        <div class="text-sm text-gray-600">
                            <p>Order Placed: <span class="font-semibold">{{ $order->created_at->format('d M Y') }}</span></p>
                            <p>Total: <span class="font-semibold">₹{{ $order->total }}</span></p>
                            <p>Dispatch To: <span class="font-semibold">{{ Auth::user()->name }}</span></p>
                        </div>
                                    <div class="flex space-x-4 text-sm">
                    {{-- Order Details Button --}}
                    <a href="{{ route('order.track', $order->id) }}"
                    class="px-4 py-2 text-[#654321] rounded-lg hover:bg-[#4a2f19] transition font-semibold text-sm  hover:text-white text-center">
                    Order Detail
                    </a>
                </div>

                    </div>

                    <!-- Products List -->
                    @foreach($order->items as $item)
                        <div class="flex items-center border-b last:border-b-0 py-2">
                            <img src="{{ asset('storage/products/'.$item->product->image) }}" alt="{{ $item->product->name }}" class="w-24 h-24 object-cover rounded mr-4">
                            <div class="flex-1">
                                <h2 class="font-semibold text-[#654321]">{{ $item->product->name }}</h2>
                                <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                                <p class="text-sm text-gray-600">Price: ₹{{ $item->price }}</p>
                            </div>
                         <div class="flex flex-col space-y-2 items-end">
    {{-- Buy Again - Filled Brown Button --}}
    <a href="#"
       class="px-4 py-2 bg-[#654321] text-[#fdf9ef] rounded-lg hover:bg-[#4a2f19] transition font-semibold text-sm text-center w-full text-center">
       Buy Again
    </a>

    {{-- Cancel Button or Cancelled Badge --}}
    @if($order->status == 'cancelled')
        <span class="px-4 py-2 border border-[#654321] text-[#654321]    rounded-lg font-semibold text-sm w-full text-center">
            Cancelled
        </span>
    @elseif(!in_array($order->status, ['delivered','shipped']))
        <form action="{{ route('order.cancel', $order->id) }}" method="POST" class="mt-2 w-full">
            @csrf
            <button type="submit" 
                class="px-4 py-2 border border-[#654321] text-[#654321] rounded-lg font-semibold hover:bg-[#654321] hover:text-[#fdf9ef] transition text-sm w-full text-center">
                Cancel Order
            </button>
        </form>
    @endif
</div>
   
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
