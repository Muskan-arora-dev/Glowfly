@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Product Details</h2>
    <div class="border p-4 rounded shadow">
        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-64 h-64 object-cover mb-4">
        <h3 class="text-xl font-semibold mb-2">{{ $product->name }}</h3>
        <p class="text-lg font-bold mb-2">₹{{ $product->price }}</p>
        <a href="{{ route('admin.products.index') }}" class="px-3 py-1 bg-gray-600 text-white rounded hover:bg-gray-700">Back</a>
    </div>
</div>
@endsection
