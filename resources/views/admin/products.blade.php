@extends('layouts.admin')

@section('content')

<style>
    .wishlist-btn:hover svg {
        stroke: #401d07;
    }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 bg-[#fdf9ef]">

    {{-- ADD PRODUCT BUTTON --}}
    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.products.create') }}" 
           class="px-4 py-2 bg-gradient-to-r from-[#4e54c8] to-[#8f94fb] text-white text-white font-semibold rounded-lg hover:bg-[#3e1e0e]">
            + Add New Product
        </a>
    </div>

    {{-- PRODUCTS GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @foreach($products as $product)
        <div class="border p-4 rounded shadow hover:shadow-lg">

            {{-- IMAGE --}}
            <img src="{{ asset($product->image) }}" 
                 class="w-full h-48 object-cover mb-4" 
                 alt="{{ $product->name }}">

            {{-- NAME --}}
            <h3 class="text-lg font-semibold text-[#654321] mb-2">
                {{ $product->name }}
            </h3>

            {{-- PRICE --}}
            <p class="text-[#654321] font-bold mb-2">
                ₹{{ $product->price }}
            </p>

            {{-- ADMIN BUTTONS --}}
            @if(auth()->user()->role == 'admin')
            <div class="flex gap-2 mt-2">

                <a href="{{ route('admin.products.show', $product->id) }}" 
                   class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Show
                </a>

                <a href="{{ route('admin.products.edit', $product->id) }}" 
                   class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                    Edit
                </a>

                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        onclick="return confirm('Are you sure?');"
                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                        Delete
                    </button>
                </form>

            </div>
            @endif

            {{-- DELIVERY DATE --}}
            <p class="mt-2 text-sm text-[#654321] font-bold">
                Deliver By: {{ \Carbon\Carbon::now()->addDays(5)->format('D, d M') }}
            </p>

        </div>
        @endforeach

    </div>

    {{-- PAGINATION --}}
    <div class="mt-6">
        {{ $products->links() }}
    </div>

</div>

@endsection
