@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-5">
        <div class="glass-card p-5 animate-up">
            <h2 class="fw-bold mb-2">Reset Password</h2>
            <p class="text-muted mb-4">Enter your email address and we'll send you a link to reset your password.</p>

            @if (session('status'))
                <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="form-label fw-medium">Email Address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="name@example.com" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary w-100 py-3 mb-4">Send Reset Link</button>
                
                <p class="text-center mb-0">
                    Remember your password? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Back to Login</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
