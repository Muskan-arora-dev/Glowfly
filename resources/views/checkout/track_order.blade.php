@extends('layouts.app')
@section('content')


<div class="max-w-4xl mx-auto p-6 bg-white rounded-2xl shadow mt-10 text-center">

    <h1 class="text-3xl font-bold text-[#654321] mb-6">Track Your Order</h1>

    <p class="mb-2">Order ID: <span class="font-semibold">{{ $order->order_id }}</span></p>
    <p class="mb-2">AWB ID: <span class="font-semibold">{{ $order->awb_id }}</span></p>
    <p class="mb-2">Payment Method: <span class="font-semibold">{{ ucfirst($order->payment_method) }}</span></p>
    <p class="mb-2">Total: ₹{{ $order->total }}</p>
    <p class="mb-4">Expected Delivery: <span class="font-semibold">{{ $deliveryDate }}</span></p>

    @php
        $steps = ['placed' => 'Placed', 'packed' => 'Packed', 'shipping' => 'Shipping', 'delivered' => 'Delivered'];
        $statusKeys = array_keys($steps);
        $currentIndex = array_search($status, $statusKeys);
    @endphp

    <div class="relative flex justify-between items-center mt-8">
        <!-- Background line -->
        <div class="absolute top-5 left-5 right-5 h-1 bg-gray-300 z-0"></div>

        <!-- Green progress line till current step -->
        <div class="absolute top-5 left-5 h-1 bg-green-500 z-10"
             style="width: {{ ($currentIndex) / (count($steps)-1) * 100 }}%;"></div>

        @foreach($steps as $key => $label)
            @php
                $stepIndex = array_search($key, $statusKeys);
                $isCompleted = $stepIndex <= $currentIndex;
            @endphp

            <div class="relative z-20 flex flex-col items-center">
                <div class="w-10 h-10 rounded-full flex items-center justify-center
                    {{ $isCompleted ? 'bg-green-500 text-white' : 'bg-white border-2 border-gray-300 text-gray-400' }}">
                    ✅
                </div>
                <span class="mt-2 text-sm font-semibold">{{ $label }}</span>
            </div>
        @endforeach
    </div>

    <a href="{{ url('/') }}"
       class="mt-8 inline-block bg-[#654321] text-[#fdf9ef] px-6 py-3 rounded-xl hover:bg-[#4a2f19]">
       Continue Shopping
    </a>

</div>
@endsection
