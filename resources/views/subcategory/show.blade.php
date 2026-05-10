    @extends('layouts.app')

    @section('content')
    <style>
        .wishlist-btn:hover svg {
            stroke: #401d07;
        }
    </style>



    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 g-[#fdf9ef]">
        <h1 class="text-4xl font-bold text-center text-[#654321] mb-8" style="font-family: 'Great Vibes', cursive;">
            {{ $sub->name }} Products
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
            @php
                $inCart = auth()->user()?->carts?->pluck('product_id')->contains($product->id) ?? false;
                $inWishlist = auth()->user()?->wishlists?->pluck('product_id')->contains($product->id) ?? false;
            @endphp

            <div class="border p-4 rounded shadow hover:shadow-lg">
                <img src="{{ asset($product->image) }}" class="w-full h-48 object-cover mb-4" alt="{{ $product->name }}">
                <h3 class="text-lg font-semibold text-[#654321] mb-2">{{ $product->name }}</h3>
                <p class="text-[#654321] font-bold mb-2">₹{{ $product->price }}</p>

                <div class="flex gap-2">
                    {{-- Add to Cart --}}
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <button
                            type="submit"
                            class="px-3 py-1 rounded border font-semibold
                            @if($inCart)
                                bg-white-500 text-[#654321] cursor-not-allowed border-[#654321]-500
                            @else
                                bg-[#654321] text-[#fdf9ef] border-[#654321] hover:bg-[#fdf9ef] hover:text-[#654321] transition-colors duration-300
                            @endif"
                            @if($inCart) disabled @endif
                        >
                            Add to Cart
                        </button>
                    </form>
<form action="{{ route('cart.buyNow', $product->id) }}" method="POST">
    @csrf
    <button type="submit"
        class="bg-[#fdf9ef] text-[#654321] border border-[#654321] px-3 py-1 rounded 
               hover:bg-[#654321] hover:text-[#fdf9ef] transition-colors duration-300">
        Buy Now
    </button>
</form>


                    {{-- Wishlist --}}
                    <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="wishlist-btn focus:outline-none">
                            <!-- Outline Heart -->
                            <svg class="w-6 h-6 heart-outline @if($inWishlist) hidden @endif" fill="none" stroke="#654321" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 016.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z"/>
                            </svg>

                            <!-- Filled Heart -->
                            <svg class="w-6 h-6 heart-filled @if(!$inWishlist) hidden @endif" fill="#654321" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 
                                2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 
                                3.41.81 4.5 2.09C13.09 3.81 14.76 3 
                                16.5 3 19.58 3 22 5.42 22 
                                8.5c0 3.78-3.4 6.86-8.55 
                                11.54L12 21.35z"/>
                            </svg>
                        </button>
                    </form>

                </div>

                {{-- Deliver By Date --}}
                <p class="mt-2 text-sm text-[#654321]  font-bold">
                    Deliver By: {{ \Carbon\Carbon::now()->addDays(5)->format('D, d M') }}
                </p>

            </div>
            @endforeach
        </div>
    </div>
    @endsection
