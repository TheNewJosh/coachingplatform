@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="glass-card p-5 animate-up mb-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('student.catalog') }}">Catalog</a></li>
                    <li class="breadcrumb-item active">{{ $course->title }}</li>
                </ol>
            </nav>
            
            <h1 class="fw-bold mb-3">{{ $course->title }}</h1>
            <p class="lead text-muted mb-4">{{ $course->description }}</p>
            
            <div class="d-flex align-items-center mb-4">
                <img src="{{ $course->coach->avatar ?? 'https://ui-avatars.com/api/?name='.$course->coach->name }}" class="profile-img me-3" style="width: 50px; height: 50px;">
                <div>
                    <h6 class="fw-bold mb-0">{{ $course->coach->name }}</h6>
                    <small class="text-muted">Expert Coach</small>
                </div>
            </div>

            @if($course->thumbnail)
                <div class="mb-4 rounded-4 overflow-hidden shadow-sm" style="height: 300px;">
                    <img src="{{ asset('storage/' . $course->thumbnail) }}" class="w-100 h-100 object-fit-cover">
                </div>
            @else
                <div class="mb-4 rounded-4 overflow-hidden shadow-sm d-flex align-items-center justify-content-center" style="height: 300px; background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                    <i class="fas fa-laptop-code text-white opacity-50" style="font-size: 5rem;"></i>
                </div>
            @endif

            <h4 class="fw-bold mb-3">Course Curriculum</h4>
            <div class="accordion accordion-flush" id="courseAccordion">
                @forelse($course->modules as $module)
                <div class="accordion-item bg-transparent">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed bg-transparent fw-bold px-0" type="button" data-bs-toggle="collapse" data-bs-target="#module{{ $module->id }}">
                            {{ $module->title }}
                        </button>
                    </h2>
                    <div id="module{{ $module->id }}" class="accordion-collapse collapse" data-bs-parent="#courseAccordion">
                        <div class="accordion-body p-0 pb-3">
                            <ul class="list-group list-group-flush">
                                @forelse($module->lessons as $lesson)
                                <li class="list-group-item bg-transparent px-0 border-0 d-flex align-items-center text-muted">
                                    <i class="fas fa-{{ $lesson->type == 'video' ? 'video' : ($lesson->type == 'audio' ? 'volume-up' : ($lesson->type == 'youtube' ? 'play-circle' : 'file-alt')) }} me-3 text-primary" style="width: 20px;"></i>
                                    {{ $lesson->title }}
                                </li>
                                @empty
                                <li class="list-group-item bg-transparent px-0 border-0 text-muted small">No lessons yet.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                @empty
                <p class="text-muted">Curriculum is being prepared.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="glass-card p-4 sticky-top animate-up" style="top: 100px; animation-delay: 0.1s;">
            <h4 class="fw-bold mb-4">Ready to start?</h4>
            
            <ul class="list-unstyled mb-4">
                <li class="mb-3 d-flex align-items-center">
                    <div class="bg-primary-light rounded-circle p-2 me-3">
                        <i class="fas fa-layer-group text-primary"></i>
                    </div>
                    <div>
                        <div class="fw-bold">{{ $course->modules->count() }} Modules</div>
                    </div>
                </li>
                <li class="mb-3 d-flex align-items-center">
                    <div class="bg-primary-light rounded-circle p-2 me-3">
                        <i class="fas fa-book-open text-primary"></i>
                    </div>
                    <div>
                        <div class="fw-bold">{{ $course->lessons()->count() }} Lessons</div>
                    </div>
                </li>
                <li class="mb-3 d-flex align-items-center">
                    <div class="bg-primary-light rounded-circle p-2 me-3">
                        <i class="fas fa-certificate text-primary"></i>
                    </div>
                    <div>
                        <div class="fw-bold">Certificate of Completion</div>
                    </div>
                </li>
            </ul>

            @if($isEnrolled)
                <div class="alert alert-success border-0 rounded-3 mb-4">
                    <i class="fas fa-check-circle me-2"></i> You are enrolled in this course.
                </div>
                <a href="{{ route('student.courses.show', $course) }}" class="btn btn-primary w-100 py-3 fw-bold">Continue Learning</a>
            @else
                <form action="{{ route('student.enroll', $course) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold shadow">Enroll Now</button>
                </form>
            @endif
        </div>
    </div>
</div>

<style>
    .bg-primary-light { background-color: rgba(99, 102, 241, 0.1); }
    .accordion-button:not(.collapsed) {
        color: var(--primary);
        box-shadow: none;
    }
</style>
@endsection
