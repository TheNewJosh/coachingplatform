@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-md-5">
        <div class="glass-card p-5 animate-up">
            <h2 class="fw-bold mb-2">Welcome Back!</h2>
            <p class="text-muted mb-4">Please login to continue your journey.</p>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-medium">Email Address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="name@example.com" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <div class="d-flex justify-content-between">
                        <label class="form-label fw-medium">Password</label>
                        <a href="{{ route('password.request') }}" class="text-primary text-decoration-none small">Forgot Password?</a>
                    </div>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100 py-3 mb-4">Login to Account</button>
                
                <p class="text-center mb-0">
                    Don't have an account? <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">Sign Up</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
