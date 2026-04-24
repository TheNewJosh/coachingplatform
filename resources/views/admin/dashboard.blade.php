@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="glass-card p-5 animate-up">
            <h1 class="fw-bold">Admin Dashboard</h1>
            <p class="text-muted">Welcome back, Admin! Here you can manage users and platform settings.</p>
            
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="glass-card p-4 text-center mb-4">
                        <h3 class="fw-bold text-primary">150</h3>
                        <p class="text-muted mb-0">Total Students</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="glass-card p-4 text-center mb-4">
                        <h3 class="fw-bold text-secondary">25</h3>
                        <p class="text-muted mb-0">Total Coaches</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="glass-card p-4 text-center mb-4">
                        <h3 class="fw-bold text-accent">45</h3>
                        <p class="text-muted mb-0">Active Courses</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="glass-card p-4 text-center mb-4">
                        <h3 class="fw-bold text-success">$12.5k</h3>
                        <p class="text-muted mb-0">Revenue</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
