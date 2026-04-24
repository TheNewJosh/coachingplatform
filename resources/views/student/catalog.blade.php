@extends('layouts.app')

@section('content')
<div class="glass-card p-5 animate-up">
    <h1 class="fw-bold mb-2">Course Catalog</h1>
    <p class="text-muted mb-5">Explore our premium self-paced mentoring programs.</p>

    <div class="row">
        @forelse($courses as $course)
        <div class="col-md-4 mb-4">
            <div class="glass-card h-100 overflow-hidden shadow-sm hover-up">
                <div style="height: 180px; background: linear-gradient(135deg, #6366f1, #8b5cf6); position: relative;">
                    @if($course->thumbnail)
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-100 h-100 object-fit-cover">
                    @endif
                    <div class="position-absolute top-0 end-0 p-3">
                        <span class="badge bg-white text-primary">Self-Paced</span>
                    </div>
                </div>
                <div class="p-4">
                    <h5 class="fw-bold mb-2">{{ $course->title }}</h5>
                    <p class="text-muted small mb-4 text-truncate-2">{{ $course->description }}</p>
                    
                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ $course->coach->avatar ?? 'https://ui-avatars.com/api/?name='.$course->coach->name }}" class="profile-img me-2" style="width: 30px; height: 30px;">
                        <small class="text-muted">By {{ $course->coach->name }}</small>
                    </div>

                    @if(auth()->user()->enrolledCourses()->where('course_id', $course->id)->exists())
                        <a href="{{ route('student.courses.show', $course) }}" class="btn btn-outline-primary w-100">Continue Learning</a>
                    @else
                        <form action="{{ route('student.enroll', $course) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">Enroll Now</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">No courses available at the moment.</p>
        </div>
        @endforelse
    </div>
</div>

<style>
    .hover-up {
        transition: transform 0.3s ease;
    }
    .hover-up:hover {
        transform: translateY(-5px);
    }
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection
