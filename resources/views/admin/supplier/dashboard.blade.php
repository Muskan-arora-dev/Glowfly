@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-8">

    {{-- Header --}}
    <div class="mb-8">
        <h2 class="text-3xl font-semibold text-[#6b3f1d]">
            Supplier Dashboard
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Welcome back, {{ $supplier->name }} ✨
        </p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

        {{-- Total Products --}}
        <div class="rounded-2xl border border-[#e8d9cc] bg-white p-6">
            <p class="text-sm text-gray-500">Total Products</p>
            <h3 class="text-4xl font-bold text-[#6b3f1d] mt-2">
                {{ $products->count() }}
            </h3>
        </div>

        {{-- Wallet --}}
        <div class="rounded-2xl border border-[#e8d9cc] bg-white p-6">
            <p class="text-sm text-gray-500">Wallet Balance</p>
            <h3 class="text-4xl font-bold text-[#6b3f1d] mt-2">
                ₹{{ number_format($supplier->wallet_balance,2) }}
            </h3>
        </div>

    </div>

    {{-- Products --}}
    <div class="rounded-2xl border border-[#e8d9cc] bg-white overflow-hidden">

        <div class="px-6 py-4 border-b border-[#e8d9cc]">
            <h4 class="text-lg font-semibold text-[#6b3f1d]">
                Products
            </h4>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-[#fdf9f5] text-[#6b3f1d]">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium">Product</th>
                        <th class="px-6 py-3 text-left font-medium">Price</th>
                        <th class="px-6 py-3 text-left font-medium">Stock</th>
                        <th class="px-6 py-3 text-left font-medium">Status</th>
                        @if(auth()->user()->role === 'admin')
                            <th class="px-6 py-3 text-left font-medium">Action</th>
                        @endif
                    </tr>
                </thead>

                <tbody class="divide-y divide-[#e8d9cc]">
                @forelse($products as $product)
                    <tr class="hover:bg-[#fdf9f5] transition">

                        <td class="px-6 py-4 flex items-center gap-3">
                            <img src="{{ asset('storage/'.$product->image) }}"
                                 class="w-12 h-12 rounded-lg border object-cover">
                            <span class="font-medium">
                                {{ $product->name }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            ₹{{ number_format($product->price,2) }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $product->quantity ?? 0 }}
                        </td>

                        <td class="px-6 py-4">
                            @if($product->status === 'approved')
                                <span class="px-3 py-1 rounded-full text-xs
                                    bg-[#e8d9cc] text-[#6b3f1d]">
                                    Approved
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs
                                    bg-[#f3e6dc] text-[#8a5a3a]">
                                    Pending
                                </span>
                            @endif
                        </td>

                        @if(auth()->user()->role === 'admin')
                        <td class="px-6 py-4">
                            @if($product->status === 'pending')
                                <a href="{{ route('admin.supplier.purchase.form', $product->id) }}"
                                   class="inline-flex items-center px-4 py-2 text-sm rounded-lg
                                          border border-[#6b3f1d] text-[#6b3f1d]
                                          hover:bg-[#6b3f1d] hover:text-white transition">
                                    Purchase
                                </a>
                            @else
                                <span class="text-gray-400 text-sm">
                                    Purchased
                                </span>
                            @endif
                        </td>
                        @endif

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            No products found
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection

@if(session('success'))
    <div class="mb-4 rounded-xl bg-green-100 border border-green-300
                px-4 py-3 text-green-800 font-medium">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 rounded-xl bg-red-100 border border-red-300
                px-4 py-3 text-red-800 font-medium">
        {{ session('error') }}
    </div>
@endif
