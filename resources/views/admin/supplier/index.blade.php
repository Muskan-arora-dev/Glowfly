@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 px-4">

    <!-- HEADER -->
    <div class="mb-6">
        <h3 class="text-2xl font-bold text-gray-800">Supplier Dashboard</h3>
        <p class="text-gray-500">Welcome, {{ $supplier->name }}</p>
    </div>

    <!-- STATS -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl p-6 shadow hover:shadow-lg transition">
            <h5 class="text-sm font-semibold">Total Products</h5>
            <h2 class="text-3xl font-bold">{{ $totalProducts }}</h2>
        </div>
        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl p-6 shadow hover:shadow-lg transition">
            <h5 class="text-sm font-semibold">Wallet Balance</h5>
            <h2 class="text-3xl font-bold">₹ {{ number_format($walletBalance,2) }}</h2>
        </div>
    </div>

    <!-- ADD PRODUCT BUTTON -->
    <div class="mb-6">
        <button id="showAddProductForm" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow">
            + Add Product
        </button>
    </div>

</div>

<!-- Modal Form -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>
<div id="addProductForm"
     class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-md z-50 hidden bg-white backdrop-blur-md rounded-lg shadow-xl border border-gray-200 p-6">

    <!-- Close Button -->
    <button id="closeAddProductForm" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl font-bold">&times;</button>

    <!-- Icon + Heading -->
    <div class="flex items-center justify-center gap-2 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 4v16m8-8H4"/>
        </svg>
        <h3 class="text-xl font-semibold text-gray-700 text-center">Add New Product</h3>
    </div>

    <form action="{{ route('supplier.products.add') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-gray-600 mb-1">Product Name</label>
            <input type="text" name="name" required
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
            <label class="block text-gray-600 mb-1">Category</label>
            <select name="category_id" required
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-600 mb-1">Subcategory</label>
            <select name="subcategory_id" required
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Select Subcategory</option>
                @foreach($subcategories as $subcategory)
                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-600 mb-1">Quantity</label>
            <input type="number" name="quantity" required min="1"
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
            <label class="block text-gray-600 mb-1">Price (₹)</label>
            <input type="number" name="price" required min="0.01" step="0.01"
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <button type="submit"
                class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white py-2 rounded-lg hover:opacity-90 transition">
            Add Product
        </button>
    </form>
</div>

<!-- JS-->
<script>
    const showBtn = document.getElementById('showAddProductForm');
    const form = document.getElementById('addProductForm');
    const closeBtn = document.getElementById('closeAddProductForm');
    const overlay = document.getElementById('overlay');

    showBtn.addEventListener('click', () => {
        form.classList.remove('hidden');
        overlay.classList.remove('hidden');
    });

    closeBtn.addEventListener('click', () => {
        form.classList.add('hidden');
        overlay.classList.add('hidden');
    });

    overlay.addEventListener('click', () => {
        form.classList.add('hidden');
        overlay.classList.add('hidden');
    });
</script>
@endsection
