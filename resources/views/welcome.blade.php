@extends('layouts.app')

@section('content')
<div class="row align-items-center py-5">
    <div class="col-lg-6 mb-5 mb-lg-0 animate-up">
        <h1 class="display-3 fw-bold mb-4">Grow at Your <span class="text-primary">Own Pace.</span></h1>
        <p class="lead text-muted mb-5">Premium mentoring and coaching platform designed for your busy life. No live sessions, no scheduling conflicts—just pure growth.</p>
        
        <div class="d-flex gap-3">
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5">Get Started</a>
            <a href="{{ route('student.catalog') }}" class="btn btn-outline-primary btn-lg px-5">Explore Courses</a>
        </div>

        <div class="row mt-5">
            <div class="col-4">
                <h4 class="fw-bold mb-0">2.5k+</h4>
                <small class="text-muted">Students</small>
            </div>
            <div class="col-4">
                <h4 class="fw-bold mb-0">50+</h4>
                <small class="text-muted">Expert Coaches</small>
            </div>
            <div class="col-4">
                <h4 class="fw-bold mb-0">120+</h4>
                <small class="text-muted">Courses</small>
            </div>
        </div>
    </div>
    <div class="col-lg-6 text-center animate-up" style="animation-delay: 0.2s;">
        <img src="https://illustrations.popsy.co/blue/online-learning.svg" alt="Coaching" class="img-fluid" style="max-height: 500px;">
    </div>
</div>

<div class="row mt-5 py-5">
    <div class="col-md-4 mb-4">
        <div class="glass-card p-5 h-100 text-center">
            <div class="bg-primary-light rounded-circle p-4 mb-4 d-inline-block">
                <i class="fas fa-clock text-primary fs-2"></i>
            </div>
            <h4 class="fw-bold">Flexible Learning</h4>
            <p class="text-muted mb-0">Learn whenever you want, wherever you are. Our platform fits into your schedule.</p>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="glass-card p-5 h-100 text-center">
            <div class="bg-secondary-light rounded-circle p-4 mb-4 d-inline-block">
                <i class="fas fa-route text-secondary fs-2"></i>
            </div>
            <h4 class="fw-bold">Guided Journeys</h4>
            <p class="text-muted mb-0">Structured modules and tasks ensure you're always moving toward your goals.</p>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="glass-card p-5 h-100 text-center">
            <div class="bg-accent-light rounded-circle p-4 mb-4 d-inline-block">
                <i class="fas fa-chart-line text-accent fs-2"></i>
            </div>
            <h4 class="fw-bold">Track Your Growth</h4>
            <p class="text-muted mb-0">Visualize your progress with milestones and detailed achievement tracking.</p>
        </div>
    </div>
</div>

<style>
    .bg-primary-light { background-color: rgba(99, 102, 241, 0.1); }
    .bg-secondary-light { background-color: rgba(236, 72, 153, 0.1); }
    .bg-accent-light { background-color: rgba(139, 92, 246, 0.1); }
</style>
@endsection
