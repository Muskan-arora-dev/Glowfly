@extends('layouts.admin')

@section('content')

<div class="max-w-3xl mx-auto bg-white shadow-lg p-6 rounded-lg">

    <h2 class="text-2xl font-bold text-[#654321] mb-4">Add New Product</h2>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- NAME --}}
        <label class="font-semibold text-[#654321]">Product Name</label>
        <input type="text" name="name" class="w-full border p-2 rounded mb-4" required>

        {{-- CATEGORY --}}
        <label class="font-semibold text-[#654321]">Category</label>
        <select name="category_id" id="category" class="w-full border p-2 rounded mb-4" required>
            <option value="">Select Category</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>

        {{-- SUBCATEGORY --}}
        <label class="font-semibold text-[#654321]">Subcategory</label>
        <select name="subcategory_id" id="subcategory" class="w-full border p-2 rounded mb-4" required>
            <option value="">Select Subcategory</option>
             @foreach($subcategories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>

        {{-- PRICE --}}
        <label class="font-semibold text-[#654321]">Price</label>
        <input type="number" name="price" class="w-full border p-2 rounded mb-4" required>

        {{-- IMAGE --}}
        <label class="font-semibold text-[#654321]">Product Image</label>
        <input type="file" name="image" class="w-full border p-2 rounded mb-4" required>

        {{-- DESCRIPTION --}}
        <label class="font-semibold text-[#654321]">Description</label>
        <textarea name="description" class="w-full border p-2 rounded mb-4" rows="4"></textarea>

        <button class="px-4 py-2 bg-[#654321] text-white rounded hover:bg-[#3e1e0e]">
            Add Product
        </button>

    </form>

</div>

{{-- AJAX for Subcategory --}}
<script>
document.getElementById('category').addEventListener('change', function () {
    let categoryId = this.value;

    fetch("/get-subcategories/" + categoryId)
        .then(response => response.json())
        .then(data => {
            let subcatSelect = document.getElementById('subcategory');
            subcatSelect.innerHTML = "<option value=''>Select Subcategory</option>";

            data.forEach(sub => {
                subcatSelect.innerHTML += `<option value="${sub.id}">${sub.name}</option>`;
            });
        });
});
</script>

@endsection
