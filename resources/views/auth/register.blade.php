@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-6">
        <div class="glass-card p-5 animate-up">
            <h2 class="fw-bold mb-2">Join CoachingFlow</h2>
            <p class="text-muted mb-4">Start your growth journey with our guided self-paced modules.</p>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-medium">Full Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="John Doe" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Email Address</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="name@example.com" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label fw-medium">Account Type</label>
                    <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                        <option value="student">Student (I want to learn)</option>
                        <option value="coach">Coach (I want to teach)</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-medium">Password</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label fw-medium">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 py-3 mb-4">Create My Account</button>
                
                <p class="text-center mb-0">
                    Already have an account? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Login</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
