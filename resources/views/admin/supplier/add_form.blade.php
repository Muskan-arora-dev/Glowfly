@extends('layouts.admin')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100 p-4">

    <!-- Add Supplier Form Card -->
    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Add New Supplier</h2>
        <p class="text-gray-500 text-sm mb-6 text-center">
            Fill in the details below to create a new supplier account.
        </p>

        <form action="{{ route('admin.suppliers.add') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Name</label>
                <input type="text" name="name" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Email -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" name="email" required
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Profile Image -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Profile Image</label>
                <input type="file" name="image" accept="image/*"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>


            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-gradient-to-r from-indigo-600 to-indigo-400 text-white py-2 rounded-lg hover:opacity-90 transition">
                Add Supplier
            </button>
        </form>
    </div>

</div>
@endsection
