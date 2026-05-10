@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <h1 class="text-4xl font-bold text-center text-[#654321] mb-10"
        style="font-family:'Great Vibes', cursive;">
        Your Shopping Cart
    </h1>

    {{-- IF CART EMPTY --}}
    @if($items->count() == 0)

        <div class="text-center bg-white p-10 rounded-2xl shadow">
            <h2 class="text-2xl font-bold text-[#654321] mb-4">Your Cart is Empty</h2>

            <a href="{{ url('/') }}"
               class="inline-block bg-[#654321] text-[#fdf9ef] px-6 py-3 rounded-xl text-lg hover:bg-[#4a2f19] transition">
                Continue Shopping
            </a>
        </div>

    @endif

    {{-- IF CART NOT EMPTY --}}
    @if($items->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- LEFT SIDE — CART ITEMS --}}
        <div class="lg:col-span-2 space-y-4">

            @foreach ($items as $item)
                <div class="relative flex gap-3 items-center p-3 bg-white rounded-2xl shadow-sm border border-[#e8dcc4] h-24">

                    {{-- REMOVE CROSS --}}
                    <form action="{{ route('cart.remove', $item->id) }}" method="POST"
                          class="absolute top-2 right-2">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 text-xl font-bold hover:text-red-700">×</button>
                    </form>

                    {{-- IMAGE --}}
                    <img src="{{ asset('products/' . $item->product->image) }}"
                         class="w-20 h-20 object-cover rounded-xl border">

                    {{-- PRODUCT DETAILS --}}
                    <div class="flex-1">
                        <h2 class="text-lg font-semibold text-[#654321]">{{ $item->product->name }}</h2>
                        <p class="text-[#654321] font-bold">₹{{ $item->product->price }}</p>

                        {{-- QTY --}}
                        <div class="flex items-center gap-2 mt-2">
                            <form action="{{ route('cart.updateQty', $item->id) }}" method="POST"
                                  class="flex items-center gap-2">
                                @csrf
                                <button name="action" value="decrease"
                                        class="px-2 py-0.5 bg-[#654321] text-white rounded">-</button>
                                <span class="px-2 py-0.5 border rounded text-[#654321] bg-[#fdf9ef]">
                                    {{ $item->quantity }}
                                </span>
                                <button name="action" value="increase"
                                        class="px-2 py-0.5 bg-[#654321] text-white rounded">+</button>
                            </form>
                        </div>
                    </div>

                </div>
            @endforeach

        </div>

        {{-- RIGHT SIDE — ORDER SUMMARY --}}
        <div class="bg-white shadow-sm rounded-2xl border border-[#e8dcc4] p-4 h-fit">

            <h2 class="text-xl font-bold text-[#654321] mb-4">Order Summary</h2>

            <div class="space-y-2 max-h-56 overflow-y-auto pr-2">
                @foreach ($items as $item)
                    <div class="flex items-center gap-2 border-b pb-2">
                        <img src="{{ asset('products/' . $item->product->image) }}"
                             class="w-12 h-12 rounded border">

                        <div class="flex-1">
                            <p class="font-semibold text-[#654321] text-sm">{{ $item->product->name }}</p>
                            <p class="text-xs text-gray-600">Qty: {{ $item->quantity }}</p>
                        </div>

                        <p class="font-bold text-[#654321] text-sm">
                            ₹{{ $item->product->price * $item->quantity }}
                        </p>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 border-t pt-2">
                <h3 class="text-lg font-bold text-[#654321]">
                    Total: ₹{{ $items->sum(fn($i) => $i->product->price * $i->quantity) }}
                </h3>
            </div>

           <a href="{{ route('checkout.show', ['product_id' => $items->pluck('product_id')->implode(',')]) }}"
   class="w-full inline-block text-center bg-[#654321] text-[#fdf9ef] py-2 rounded-xl text-base font-semibold hover:bg-[#4a2f19] transition mt-4">
   Buy Now
</a>

        </div>

    </div>

    {{-- RECOMMENDED --}}
    @if(isset($recommended) && $recommended->count() > 0)
    <h2 class="text-2xl font-bold text-[#654321] mt-8 mb-4">Recommended For You</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($recommended as $product)
            <div class="bg-white p-3 rounded-xl shadow-sm border border-[#e8dcc4] h-48">
                <img src="{{ asset('products/' . $product->image) }}"
                     class="w-full h-32 object-cover rounded-lg">

                <h3 class="text-md font-semibold text-[#654321] mt-2">{{ $product->name }}</h3>
                <p class="font-bold text-[#654321] text-sm">₹{{ $product->price }}</p>
            </div>
        @endforeach
    </div>
    @endif

    @endif

</div>
@endsection
