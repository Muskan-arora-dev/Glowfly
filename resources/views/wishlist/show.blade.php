    @extends('layouts.app')

    @section('content')
    <style>

    /* Heart toggle JS controlled */
    .heart-filled {
        display: none;
    }

    </style>

   

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-white">
        <h1 class="text-4xl font-bold text-center text-[#654321] mb-8" 
            style="font-family: 'Great Vibes', cursive;">
            Your Wishlist
        </h1>

        @if($items->isEmpty())
           <div class="text-center bg-white p-10 rounded-2xl shadow">
            <h2 class="text-2xl font-bold text-[#654321] mb-4">Your Wishlist is Empty</h2>

            <a href="{{ url('/') }}"
               class="inline-block bg-[#654321] text-[#fdf9ef] px-6 py-3 rounded-xl text-lg hover:bg-[#4a2f19] transition">
                Continue Shopping
            </a>
        </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($items as $item)
                    <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-[#e8dcc4] hover:shadow-xl transition">

                        <!-- Product Image -->
                        <div class="w-full h-56">
                            <img src="{{ asset('products/' . $item->product->image) }}" 
                                class="w-full h-full object-cover" alt="{{ $item->product->name }}">
                        </div>

                        <div class="p-4">
                            <!-- Product Name & Price -->
                            <h3 class="text-lg font-semibold text-[#654321] mb-1">{{ $item->product->name }}</h3>
                            <p class="text-[#654321] font-bold mb-3">₹{{ $item->product->price }}</p>

                            <!-- Buttons -->
                            <div class="flex gap-2 mt-3">

                                <!-- Add to Cart Button -->
                                <form action="{{ route('cart.add', $item->product->id) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button class="w-full bg-[#654321] text-[#fdf9ef] px-3 py-1 rounded 
                                                hover:bg-[#4a2f19] transition font-semibold">
                                        Add to Cart
                                    </button>
                                </form>

                                <!-- Remove Button -->
                                <form action="{{ route('wishlist.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="w-full bg-[#654321] text-[#fdf9ef] px-3 py-1 rounded hover:bg-[#4a2f19] transition font-semibold">
                                        Remove
                                    </button>
                                </form>


                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Heart Toggle JS -->
    <script>
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault(); // prevent form submit for demo toggle
            const outline = this.querySelector('.heart-outline');
            const filled = this.querySelector('.heart-filled');

            if(outline.style.display !== 'none') {
                outline.style.display = 'none';
                filled.style.display = 'block';
            } else {
                outline.style.display = 'block';
                filled.style.display = 'none';
            }
        });
    });
    </script>

    @endsection
