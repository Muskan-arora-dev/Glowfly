@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 100vh; background: #f4f2ef; padding: 20px;">

    <div class="card shadow-lg p-5" 
         style="max-width: 480px; width: 100%; border-radius: 1.5rem; box-shadow: 0 20px 50px rgba(0,0,0,0.25);">

        <!-- Header -->
        <div class="text-center mb-5">
            <h3 class="fw-bold" style="color: #401d07;">🚀 Become a Delivery Partner</h3>
            <p class="text-muted small">Fill the form below to start your journey</p>
        </div>

        <!-- Messages -->
        @if(session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        @if(Auth::user()->delivery_status == 'approved')
            <div class="alert alert-success text-center">
                🎉 You are already approved as a Delivery Partner
            </div>
        @elseif(Auth::user()->delivery_status == 'pending')
            <div class="alert alert-warning text-center">
                ⏳ Your request is under review. Please wait for admin approval.
            </div>
        @else
        <!-- Form -->
        <form method="POST" action="{{ route('delivery.apply.submit') }}" enctype="multipart/form-data">
            @csrf

            <!-- Full Name -->
            <div class="mb-3">
                <label class="form-label fw-semibold" style="color: #401d07;">Full Name</label>
                <input type="text" class="form-control form-control-lg shadow-sm px-3 py-2"
                       value="{{ Auth::user()->name }}" readonly style="width: 100%; border-radius: 0.75rem;">
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label fw-semibold" style="color: #401d07;">Email</label>
                <input type="email" class="form-control form-control-lg shadow-sm px-3 py-2"
                       value="{{ Auth::user()->email }}" readonly style="width: 100%; border-radius: 0.75rem;">
            </div>

            <!-- Phone -->
            <div class="mb-3">
                <label class="form-label fw-semibold" style="color: #401d07;">Phone</label>
                <input type="text" name="phone" class="form-control form-control-lg shadow-sm px-3 py-2"
                       placeholder="Enter your phone" value="{{ Auth::user()->phone ?? '' }}" required 
                       style="width: 100%; border-radius: 0.75rem;">
            </div>

            <!-- Address -->
            <div class="mb-4">
                <label class="form-label fw-semibold" style="color: #401d07;">Address</label>
                <textarea name="address" class="form-control form-control-lg shadow-sm px-3 py-2"
                          rows="4" placeholder="Enter your address" required 
                          style="width: 100%; border-radius: 0.75rem;"></textarea>
            </div>

            <!-- License Upload -->
            <div class="mb-4">
                <label class="form-label fw-semibold" style="color: #401d07;">Driving License </label>
                <input type="file" name="license_image" class="form-control form-control-lg shadow-sm px-3 py-2" 
                       accept="image/*" required style="width: 100%; border-radius: 0.75rem;">
                <small class="text-muted">Upload a clear image of your driving/license document.</small>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-custom btn-lg w-100 fw-bold shadow" 
                    style="padding: 12px; border-radius: 0.75rem;">
                Apply Now
            </button>
        </form>
        @endif

    </div>
</div>

<style>
.card {
    border: none;
}

.form-control:focus {
    border-color: #401d07;
    box-shadow: 0 0 0 0.2rem rgba(64, 29, 7, 0.25);
    transition: all 0.3s ease;
}

.btn-custom {
    background-color: #401d07;
    color: #fff;
    transition: all 0.3s ease;
}

.btn-custom:hover {
    background-color: #2f1303;
    box-shadow: 0 6px 20px rgba(64, 29, 7, 0.4);
    transform: translateY(-2px);
}

@media (max-width: 576px) {
    .card {
        padding: 30px 20px;
        border-radius: 1rem;
    }
    .form-control {
        font-size: 1rem;
    }
    .btn-custom {
        font-size: 1rem;
        padding: 10px;
    }
}
</style>
@endsection
