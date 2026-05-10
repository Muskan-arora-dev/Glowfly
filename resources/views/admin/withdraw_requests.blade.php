@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
<h3 class="fw-bold mb-3">Withdraw Requests</h3>

@foreach($requests as $r)
<div class="card mb-2">
<div class="card-body d-flex justify-content-between align-items-center">
    <div>
        <b>{{ $r->user->name }}</b><br>
        ₹ {{ $r->amount }}
    </div>

    <div>
        <span class="badge bg-warning">{{ ucfirst($r->status) }}</span>
        @if($r->status=='pending')
        <form method="POST" action="/admin/withdraw-approve/{{ $r->id }}" class="d-inline">
            @csrf
            <button class="btn btn-success btn-sm">Approve</button>
        </form>
        <form method="POST" action="/admin/withdraw-reject/{{ $r->id }}" class="d-inline">
            @csrf
            <button class="btn btn-danger btn-sm">Reject</button>
        </form>
        @endif
    </div>
</div>
</div>
@endforeach
</div>
@endsection
