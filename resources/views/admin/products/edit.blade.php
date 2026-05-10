@extends('layouts.admin')

@section('content')
<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="max-w-3xl mx-auto bg-[#fdf9ef] p-8 rounded-xl shadow-lg">
    @csrf
    @method('PUT')

    <h2 class="text-3xl font-bold text-[#654321] mb-6">Edit Product</h2>

    <!-- Name -->
    <div class="mb-4">
        <label class="block mb-2 font-semibold text-[#654321]">Name:</label>
        <input type="text" name="name" value="{{ old('name', $product->name) }}" class="border border-[#654321] p-2 w-full rounded" placeholder="Enter product name">
        @error('name') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Price -->
    <div class="mb-4">
        <label class="block mb-2 font-semibold text-[#654321]">Price:</label>
        <input type="text" name="price" value="{{ old('price', $product->price) }}" class="border border-[#654321] p-2 w-full rounded" placeholder="Enter price">
        @error('price') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Category Dropdown -->
    <div class="mb-4">
        <label class="block mb-2 font-semibold text-[#654321]">Category:</label>
        <select name="category_id" class="border p-2 w-full rounded">
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Subcategory Dropdown -->
    <div class="mb-4">
        <label class="block mb-2 font-semibold text-[#654321]">Subcategory:</label>
        <select name="subcategory_id" class="border p-2 w-full rounded">
            <option value="">Select Subcategory</option>
            @foreach($subcategories as $subcategory)
                <option value="{{ $subcategory->id }}" {{ $product->subcategory_id == $subcategory->id ? 'selected' : '' }}>
                    {{ $subcategory->name }}
                </option>
            @endforeach
        </select>
        @error('subcategory_id') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <!-- Image -->
    <div class="mb-6">
        <label class="block mb-2 font-semibold text-[#654321]">Image:</label>
        <input type="file" name="image" class="border border-[#654321] p-2 w-full rounded">
        @if($product->image)
            <img src="{{ asset($product->image) }}" class="w-32 h-32 mt-2 rounded">
        @endif
        @error('image') <p class="text-red-600 mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="flex gap-4">
        <button type="submit" class="px-6 py-2 bg-[#654321] text-[#fdf9ef] rounded hover:bg-[#543210] transition">Update</button>
        <a href="{{ route('admin.products.index') }}" class="px-6 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 transition">Cancel</a>
    </div>
</form>
@endsection
