@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto px-4 py-8">
    
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-[#654321]">All Products</h1>

        <a href="{{ route('admin.products.create') }}"
           class="px-4 py-2 bg-[#654321] text-white rounded-lg hover:bg-[#40210a]">
            + Add New Product
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="border bg-white rounded-lg p-4 shadow hover:shadow-xl">
            
            <img src="{{ asset($product->image) }}"
                 class="w-full h-48 object-cover rounded mb-4">

            <h3 class="text-lg font-semibold text-[#654321]">{{ $product->name }}</h3>
            <p class="font-bold text-[#654321] mb-2">₹{{ $product->price }}</p>

            <div class="flex gap-2">
                <a href="{{ route('admin.products.show', $product->id) }}"
                   class="px-3 py-1 bg-blue-600 text-white rounded">Show</a>

                <a href="{{ route('admin.products.edit', $product->id) }}"
                   class="px-3 py-1 bg-green-600 text-white rounded">Edit</a>

                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button class="px-3 py-1 bg-red-600 text-white rounded">Delete</button>
                </form>
            </div>

        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>

</div>

@endsection
