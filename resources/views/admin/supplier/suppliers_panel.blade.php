@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4 relative">

    <!-- Heading + Total Suppliers + Add Supplier Button -->
    <div class="flex flex-wrap items-center justify-between mb-6">
        <div class="text-left">
            <h3 class="text-2xl font-bold text-gray-800 mb-1">Suppliers Dashboard</h3>
            <p class="text-gray-500">Manage suppliers, view stats, and add new ones</p>
        </div>

        <div class="flex items-center gap-4 flex-wrap mt-4 lg:mt-0">
            <div class="inline-block bg-gradient-to-r from-[#4e54c8] to-[#8f94fb] text-white px-5 py-3 rounded-lg shadow-lg font-bold">
                Total Suppliers: {{ $totalSuppliers ?? 0 }}
            </div>

            <button id="showAddForm"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-[#4e54c8] to-[#8f94fb] text-white px-5 py-3 rounded-lg shadow-lg font-semibold transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4v16m8-8H4"/>
                </svg>
                Add Supplier
            </button>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-5 text-center font-medium">
            {{ session('success') }}
        </div>
    @endif

    <!-- Suppliers Table / Cards -->
    <div class="suppliers-table-container overflow-x-auto mt-6 hidden lg:block">
        <table class="min-w-full table-auto border-collapse">
            <thead class="bg-gradient-to-r from-[#4e54c8] to-[#8f94fb] text-white">
            <tr>
                <th class="px-6 py-3 text-left">#</th>
                <th class="px-6 py-3 text-left">Name</th>
                <th class="px-6 py-3 text-left">Email</th>
                <th class="px-6 py-3 text-left">Wallet Balance</th>
                <th class="px-6 py-3 text-center">Action</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
            @forelse($suppliers as $index => $supplier)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-3">{{ $index + 1 }}</td>
                    <td class="px-6 py-3">{{ $supplier->name }}</td>
                    <td class="px-6 py-3">{{ $supplier->email }}</td>
                    <td class="px-6 py-3">₹{{ number_format($supplier->wallet_balance, 2) }}</td>
                    <td class="px-6 py-3 text-center flex justify-center gap-2">
                        <a href="{{ route('admin.suppliers.dashboard', $supplier->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">View</a>
                        <form action="{{ route('admin.supplier.delete', $supplier->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600" onclick="return confirm('Delete this supplier?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-gray-400">No suppliers found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <!-- Suppliers Cards for Small Screens -->
    <div class="suppliers-cards lg:hidden space-y-4 mt-6">
        @forelse($suppliers as $supplier)
            <div class="bg-white p-4 rounded-lg shadow-md border border-gray-200">
                <h5 class="font-semibold text-gray-800">{{ $supplier->name }}</h5>
                <p class="text-gray-600 text-sm">Email: {{ $supplier->email }}</p>
                <p class="text-gray-600 text-sm">Wallet: ₹{{ number_format($supplier->wallet_balance, 2) }}</p>
                <div class="mt-2 flex gap-2">
                    <a href="{{ route('admin.suppliers.dashboard', $supplier->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">View</a>
                    <form action="{{ route('admin.supplier.delete', $supplier->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm" onclick="return confirm('Delete this supplier?')">Delete</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-400">No suppliers found</p>
        @endforelse
    </div>

</div>

<!-- Modal Form -->
<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>
<div id="addSupplierForm"
     class="fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full max-w-md z-50 hidden bg-white backdrop-blur-md rounded-lg shadow-xl border border-gray-200 p-6">

    <!-- Close Button -->
    <button id="closeForm" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl font-bold">&times;</button>

    <!-- Icon + Heading -->
    <div class="flex items-center justify-center gap-2 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M12 4v16m8-8H4"/>
        </svg>
        <h3 class="text-xl font-semibold text-gray-700 text-center">Add New Supplier</h3>
    </div>

    <form action="{{ route('admin.suppliers.add') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-gray-600 mb-1">Name</label>
            <input type="text" name="name" required
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
            <label class="block text-gray-600 mb-1">Email</label>
            <input type="email" name="email" required
                   class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <button type="submit"
                class="w-full bg-gradient-to-r from-[#4e54c8] to-[#8f94fb] text-white py-2 rounded-lg hover:opacity-90 transition">
            Add Supplier
        </button>
    </form>
</div>

<!-- JS: Show/Hide Modal -->
<script>
    const showBtn = document.getElementById('showAddForm');
    const form = document.getElementById('addSupplierForm');
    const closeBtn = document.getElementById('closeForm');
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
