@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">

    <h3 class="fw-bold mb-3">Assign Orders to Delivery Partner</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- DESKTOP TABLE -->
    <div class="card shadow-sm d-none d-md-block">
        <div class="card-body p-0">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#Order</th>
                        <th>User</th>
                        <th>Delivery Charge</th>
                        <th>Assign Delivery Partner</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>₹ {{ $order->delivery_charge }}</td>
                        <td>
                            <form method="POST" action="/admin/assign-orders/{{ $order->id }}">
                                @csrf
                                <select name="delivery_partner_id" class="form-select form-select-sm" required>
                                    <option value="">Select Delivery</option>
                                    @foreach($deliveryPartners as $dp)
                                        <option value="{{ $dp->id }}">{{ $dp->name }}</option>
                                    @endforeach
                                </select>
                        </td>
                        <td>
                                <button class="btn btn-primary btn-sm">
                                    Assign
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">
                            No orders pending for assignment
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- MOBILE CARDS -->
    <div class="d-md-none">
        @foreach($orders as $order)
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h6>Order #{{ $order->id }}</h6>
                <p class="mb-1">User: {{ $order->user->name }}</p>
                <p class="mb-2">Delivery Charge: ₹ {{ $order->delivery_charge }}</p>

                <form method="POST" action="/admin/assign-orders/{{ $order->id }}">
                    @csrf
                    <select name="delivery_partner_id" class="form-select mb-2" required>
                        <option value="">Select Delivery</option>
                        @foreach($deliveryPartners as $dp)
                            <option value="{{ $dp->id }}">{{ $dp->name }}</option>
                        @endforeach
                    </select>

                    <button class="btn btn-primary w-100 btn-sm">
                        Assign Order
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection
