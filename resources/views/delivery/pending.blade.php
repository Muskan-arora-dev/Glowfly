@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100 theme-bg p-3">

    <div class="card waiting-card text-center">

        <!-- Animated Emoji -->
        <div class="emoji-container mb-4">
            <span class="emoji">⏳</span>
            <span class="emoji">⏳</span>
            <span class="emoji">⏳</span>
        </div>

        <!-- Heading -->
        <h2 class="fw-bold mb-3 theme-text">⏳ Waiting for Review</h2>
        <p class="text-muted mb-4">
            Please wait for admin approval. Once approved, you’ll get a confirmation email from <b>GlowFly</b>.
        </p>

        <!-- INLINE + CENTER BUTTONS -->
        <div class="d-flex justify-content-center align-items-center gap-3 flex-wrap">

            <a href="{{ route('home') }}" class="btn theme-btn">
                 Back to Home
            </a>

        </div>
    </div>
</div>

<style>
/* ================= THEME ================= */
.theme-text{
    color:#654321;
}

/* Card */
.waiting-card{
    max-width:500px;
    width:100%;
    padding:3rem;
    border-radius:1.5rem;
    background:#fff;
    box-shadow:0 20px 45px rgba(101,67,33,0.25);
}

/* Emoji animation */
.emoji-container{
    display:flex;
    justify-content:center;
    gap:10px;
    font-size:2.5rem;
}
.emoji{
    animation:bounce 1.5s infinite;
}
.emoji:nth-child(2){ animation-delay:0.3s; }
.emoji:nth-child(3){ animation-delay:0.6s; }

@keyframes bounce{
    0%,100%{ transform:translateY(0); }
    50%{ transform:translateY(-18px); }
}

/* Buttons */
.theme-btn{
    background:#654321;
    color:#f7deae;
    padding:12px 26px;
    font-weight:600;
    border-radius:0.75rem;
    transition:.3s;
}
.theme-btn:hover{
    background:#4b2e1f;
    color:#fff;
    transform:translateY(-2px);
}

.cancel-btn{
    background:#b45309;
    color:#fff;
    padding:12px 26px;
    font-weight:600;
    border-radius:0.75rem;
    transition:.3s;
    border:none;
}
.cancel-btn:hover{
    background:#92400e;
    transform:translateY(-2px);
}

/* Responsive */
@media(max-width:576px){
    .waiting-card{ padding:2rem; }
    .emoji-container{ font-size:2rem; }
}
</style>
@endsection
