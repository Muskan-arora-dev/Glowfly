@extends('layouts.admin')

@section('content')
<h2 class="text-xl font-bold mb-4">Pending Supplier Products</h2>

<table class="table-auto w-full border">
    <thead>
        <tr>
            <th>Product</th>
            <th>Supplier</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->supplier->name }}</td>
            <td>₹{{ $product->price }}</td>
            <td>{{ $product->quantity }}</td>
            <td>₹{{ $product->price * $product->quantity }}</td>
            <td>
                <form method="POST"
                      action="{{ route('admin.product.approve', $product->id) }}">
                    @csrf
                    <button class="bg-green-600 text-white px-3 py-1 rounded">
                        Approve & Purchase
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
