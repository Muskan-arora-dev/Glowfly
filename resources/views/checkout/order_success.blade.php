@extends('layouts.app')
@section('content')


<div class="max-w-3xl mx-auto p-6 bg-white rounded-2xl shadow mt-10 text-center relative">


    <h1 class="text-3xl font-bold text-[#654321] mb-6">Order Placed Successfully!</h1>
     <!-- Tick icon -->
    <div class="text-green-500 mb-4 text-6xl">
        ✅
    </div>

    <p class="mb-2">Order ID: <span class="font-semibold">{{ $order->order_id }}</span></p>
    <p class="mb-2">AWB ID: <span class="font-semibold">{{ $order->awb_id }}</span></p>
    <p class="mb-2">Payment Method: <span class="font-semibold">{{ ucfirst($order->payment_method) }}</span></p>
    <p class="mb-2">Total: ₹{{ $order->total }}</p>

    <!-- Track Order Button -->
    <a href="{{ route('order.track', $order->id) }}"
   class="mt-6 inline-block bg-[#654321] text-[#fdf9ef] px-6 py-3 rounded-xl hover:bg-[#4a2f19]">
   Track Order
</a>

</div>

<!-- Sound Alert -->
<audio id="orderSound" autoplay>
    <source src="{{ asset('sounds/order-placed.mp3') }}" type="audio/mpeg">
</audio>

<script>
    // Play sound on page load
    document.getElementById('orderSound').play();
</script>
@endsection
