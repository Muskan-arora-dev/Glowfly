@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-3">My Wallet</h3>

    <div class="alert alert-success">
        Wallet Balance: ₹ {{ Auth::user()->wallet_balance }}
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="/delivery/wallet/withdraw" class="mb-4">
        @csrf
        <div class="input-group">
            <input type="number" name="amount" class="form-control" placeholder="Enter amount">
            <button class="btn btn-primary">Withdraw</button>
        </div>
    </form>

    <h5>Withdraw History</h5>
    @foreach($withdraws as $w)
        <div class="card mb-2">
            <div class="card-body d-flex justify-content-between">
                <span>₹ {{ $w->amount }}</span>
                <span class="badge bg-{{ $w->status=='approved'?'success':($w->status=='rejected'?'danger':'warning') }}">
                    {{ ucfirst($w->status) }}
                </span>
            </div>
        </div>
    @endforeach
</div>
@endsection
