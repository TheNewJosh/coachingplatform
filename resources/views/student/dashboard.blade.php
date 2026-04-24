@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="glass-card p-5 animate-up">
                <h1 class="fw-bold mb-4">Welcome back, {{ auth()->user()->name }}! 🚀</h1>

                <div class="row">
                    <div class="col-md-8">
                        <h4 class="fw-bold mb-3">Your Progress</h4>
                        @forelse($enrolledCourses as $course)
                            <div class="glass-card p-4 mb-4 border-start border-primary border-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="fw-bold mb-0">{{ $course->title }}</h5>
                                    @if($course->progress_percent == 100)
                                    <span class="badge bg-success">Completed</span>
                                    @else
                                    <span class="badge bg-primary">In Progress</span>
                                    @endif
                                </div>
                                <div class="progress mb-3" style="height: 10px; border-radius: 5px;">
                                    <div class="progress-bar bg-primary" style="width: {{ $course->progress_percent }}%;"></div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">{{ $course->progress_percent }}% Complete &bull; {{ $course->lessons_count }} Lessons</small>
                                    <div>
                                        @if($course->progress_percent == 100)
                                            <a href="{{ route('student.courses.certificate', $course) }}" class="btn btn-success btn-sm me-2"><i class="fas fa-certificate me-1"></i> Certificate</a>
                                        @endif
                                        <a href="{{ route('student.courses.show', $course) }}" class="btn btn-primary btn-sm">{{ $course->progress_percent == 100 ? 'View Course' : 'Continue Learning' }}</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                        <div class="glass-card p-5 text-center mb-4">
                            <p class="text-muted">You are not enrolled in any courses yet.</p>
                            <a href="{{ route('student.catalog') }}" class="btn btn-primary">Browse Catalog</a>
                        </div>
                        @endforelse

                        <h4 class="fw-bold mb-3 mt-5">Explore New Courses</h4>
                        <div class="row">
                            @forelse($exploreCourses as $course)
                            <div class="col-md-6 mb-4">
                                <div class="glass-card h-100 overflow-hidden">
                                    <div style="height: 150px; background: linear-gradient(135deg, #6366f1, #8b5cf6); position: relative;">
                                        @if($course->thumbnail)
                                            <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-100 h-100 object-fit-cover">
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <h5 class="fw-bold">{{ $course->title }}</h5>
                                        <p class="text-muted small text-truncate-2">{{ $course->description }}</p>
                                        <a href="{{ route('student.courses.details', $course) }}" class="btn btn-outline-primary btn-sm w-100">View Details</a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12">
                                <p class="text-muted">No new courses available right now.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="glass-card p-4">
                            <h5 class="fw-bold mb-4">Certificates & Rewards</h5>

                            <!-- Certificates -->
                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-certificate me-2"></i> Certificates</h6>
                            @php 
                                $completedCourses = $enrolledCourses->filter(function($c) {
                                    return $c->progress_percent == 100;
                                });
                            @endphp
                            @forelse($completedCourses as $cCourse)
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-success rounded p-2 me-3 d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                        <i class="fas fa-file-contract text-white"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $cCourse->title }}</h6>
                                        <a href="{{ route('student.courses.certificate', $cCourse) }}" class="small text-decoration-none">View Certificate</a>
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted small mb-4">Complete a course to earn a certificate.</p>
                            @endforelse

                            <!-- Badges -->
                            <h6 class="fw-bold text-primary mb-3 mt-4"><i class="fas fa-medal me-2"></i> Badges Earned</h6>
                            @php $badges = auth()->user()->badges; @endphp
                            @forelse($badges as $badge)
                            <div class="d-flex align-items-center mb-3">
                                <div class="me-3">
                                    @if($badge->icon)
                                        <img src="{{ asset('storage/' . $badge->icon) }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded-circle p-2 d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                                            <i class="fas fa-trophy text-warning"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $badge->name }}</h6>
                                    <small class="text-muted">{{ Str::limit($badge->description, 50) }}</small>
                                </div>
                            </div>
                            @empty
                            <p class="text-muted mb-4 small">Complete courses to earn badges!</p>
                            @endforelse

                            <!-- Gifts & Rewards -->
                            <h6 class="fw-bold text-primary mb-3 mt-4"><i class="fas fa-gift me-2"></i> Gifts & Rewards</h6>
                            @php $rewards = auth()->user()->rewards; @endphp
                            @forelse($rewards as $reward)
                            <div class="d-flex align-items-start mb-3 border-start border-primary border-3 ps-3">
                                @if($reward->image)
                                    <img src="{{ asset('storage/' . $reward->image) }}" class="rounded me-3 shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-primary bg-opacity-10 rounded p-2 me-3 d-flex justify-content-center align-items-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-gift text-primary fs-4"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-1 fw-bold text-dark">{{ $reward->name }}</h6>
                                    @if($reward->message)
                                        <p class="mb-1 small text-muted fst-italic">"{{ $reward->message }}"</p>
                                    @endif
                                    <small class="text-muted" style="font-size: 0.75rem;">From: {{ $reward->coach->name }} &bull; {{ $reward->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            @empty
                            <p class="text-muted small mb-0">Keep up the good work to earn gifts from your coach!</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
