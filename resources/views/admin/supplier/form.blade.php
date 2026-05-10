@extends('layouts.admin')

@section('content')
<style>
    :root{
        --brown:#6b3f1d;
        --light:#fdf9f5;
        --border:#e8d9cc;
    }
</style>

<div class="max-w-6xl mx-auto px-6 py-8">

    {{-- Page Title --}}
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-[var(--brown)]">
            Purchase Product
        </h2>
        <p class="text-sm text-gray-500 mt-1">
            Buy stock from supplier & approve product
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Product Info Card --}}
        <div class="lg:col-span-1">
           <div class="rounded-2xl bg-gradient-to-r from-[#4e54c8] to-[#8f94fb] text-white p-6 shadow-sm">

                <h4 class="text-lg font-semibold mb-2">
                    {{ $product->name }}
                </h4>

                <p class="text-sm opacity-80 mb-1">
                    Price per unit
                </p>

                <div class="text-3xl font-bold">
                    ₹{{ number_format($product->price,2) }}
                </div>

                <div class="mt-4 text-sm opacity-75">
                    Supplier ID: {{ $product->supplier_id }}
                </div>
            </div>
        </div>

        {{-- Purchase Form --}}
        <div class="lg:col-span-2">
            <div class="rounded-2xl border border-[var(--border)] bg-white shadow-sm">

                <div class="px-6 py-4 border-b border-[var(--border)]">
                    <h4 class="font-semibold text-[var(--brown)]">
                        Purchase Details
                    </h4>
                </div>

                <form method="POST"
                      action="{{ route('admin.purchase.store', $product->id) }}"
                      class="p-6 space-y-5">
                    @csrf

                    {{-- Quantity --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Quantity
                        </label>
                        <input type="number"
                               name="quantity"
                               id="quantity"
                               min="1"
                               required
                               class="w-full rounded-lg border border-[var(--border)]
                                      px-4 py-2 focus:outline-none
                                      focus:ring-2 focus:ring-[var(--brown)]">
                    </div>

                    {{-- Total --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">
                            Total Amount
                        </label>
                        <input type="text"
                               id="total"
                               readonly
                               value="₹0.00"
                               class="w-full rounded-lg bg-[var(--light)]
                                      border border-[var(--border)]
                                      px-4 py-2 font-semibold">
                    </div>

                    {{-- Action --}}
                    <div class="pt-3">
                       <button type="submit"
    class="inline-flex items-center justify-center
           px-6 py-3 rounded-xl
           bg-gradient-to-r from-[#4e54c8] to-[#8f94fb]
           text-white font-semibold
           shadow-md hover:shadow-lg
           hover:scale-[1.02] transition-all duration-200">
    Confirm Purchase
</button>

                    </div>

                </form>

            </div>
        </div>

    </div>

</div>

{{-- JS --}}
<script>
    const price = {{ $product->price }};
    const qty = document.getElementById('quantity');
    const total = document.getElementById('total');

    qty.addEventListener('input', () => {
        let q = parseInt(qty.value) || 0;
        total.value = '₹' + (price * q).toFixed(2);
    });
</script>
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
