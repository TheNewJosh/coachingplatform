@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="glass-card p-4 sticky-top" style="top: 100px;">
            <h4 class="fw-bold mb-4">Course Content</h4>
            <div class="accordion accordion-flush" id="courseAccordion">
                @foreach($course->modules as $module)
                <div class="accordion-item bg-transparent">
                    <h2 class="accordion-header">
                        <button class="accordion-button {{ (isset($lesson) && $lesson->module_id == $module->id) ? '' : 'collapsed' }} bg-transparent fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#module{{ $module->id }}">
                            {{ $module->title }}
                        </button>
                    </h2>
                    <div id="module{{ $module->id }}" class="accordion-collapse collapse {{ (isset($lesson) && $lesson->module_id == $module->id) ? 'show' : '' }}" data-bs-parent="#courseAccordion">
                        <div class="accordion-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach($module->lessons as $l)
                                <a href="{{ route('student.lessons.show', ['course' => $course->id, 'lesson' => $l->id]) }}" class="list-group-item list-group-item-action bg-transparent border-0 d-flex justify-content-between align-items-center py-3 {{ (isset($lesson) && $lesson->id == $l->id) ? 'active rounded-3' : '' }}">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-{{ $l->type == 'video' ? 'video' : ($l->type == 'audio' ? 'volume-up' : ($l->type == 'youtube' ? 'play-circle' : 'file-alt')) }} me-2 {{ (isset($lesson) && $lesson->id == $l->id) ? 'text-white' : 'text-primary' }}"></i>
                                        <span>{{ $l->title }}</span>
                                    </div>
                                    @if(auth()->user()->progress()->where('lesson_id', $l->id)->exists())
                                        <i class="fas fa-check-circle {{ (isset($lesson) && $lesson->id == $l->id) ? 'text-white' : 'text-success' }}"></i>
                                    @endif
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="glass-card p-5 animate-up">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('student.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{ $course->title }}</li>
                </ol>
            </nav>
            
            @if(isset($lesson))
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="fw-bold mb-0">{{ $lesson->title }}</h1>
                    @if(!auth()->user()->progress()->where('lesson_id', $lesson->id)->exists())
                        <form action="{{ route('student.lessons.complete', $lesson) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success"><i class="fas fa-check me-2"></i> Mark Complete</button>
                        </form>
                    @else
                        <span class="badge bg-success py-2 px-3"><i class="fas fa-check-circle me-1"></i> Completed</span>
                    @endif
                </div>

                <!-- Lesson Content Area -->
                <div class="lesson-content mb-5">
                    @if($lesson->type == 'video' && $lesson->media_url)
                        <div class="ratio ratio-16x9 mb-4 rounded-4 overflow-hidden shadow">
                            <video controls>
                                <source src="{{ asset('storage/' . $lesson->media_url) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    @elseif($lesson->type == 'youtube' && $lesson->media_url)
                        <div class="ratio ratio-16x9 mb-4 rounded-4 overflow-hidden shadow">
                            @php
                                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $lesson->media_url, $matches);
                                $youtubeId = $matches[1] ?? null;
                            @endphp
                            @if($youtubeId)
                                <iframe src="https://www.youtube.com/embed/{{ $youtubeId }}" allowfullscreen></iframe>
                            @else
                                <div class="alert alert-warning">Invalid YouTube URL.</div>
                            @endif
                        </div>
                    @elseif($lesson->type == 'audio' && $lesson->media_url)
                        <div class="card bg-light border-0 rounded-4 p-4 mb-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary rounded-circle p-3 me-3">
                                    <i class="fas fa-music text-white fs-4"></i>
                                </div>
                                <h5 class="fw-bold mb-0">Audio Lesson</h5>
                            </div>
                            <audio controls class="w-100">
                                <source src="{{ asset('storage/' . $lesson->media_url) }}" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    @endif

                    @if($lesson->content)
                        <div class="content-body fs-5 text-muted" style="line-height: 1.8;">
                            {!! nl2br(e($lesson->content)) !!}
                        </div>
                    @endif
                </div>

            @else
                <h1 class="fw-bold mb-4">{{ $course->title }}</h1>
                <div class="alert alert-info border-0 rounded-3 p-4 mb-5">
                    <h5 class="fw-bold"><i class="fas fa-info-circle me-2"></i> Welcome to the program!</h5>
                    <p class="mb-0">Select a lesson from the sidebar to begin your journey. Remember, this is a self-paced course, so take your time to absorb the material.</p>
                </div>
                <div class="text-center py-5">
                    <img src="https://illustrations.popsy.co/blue/studying.svg" style="max-width: 300px;" class="mb-4">
                    <h3 class="fw-bold">Ready to Start?</h3>
                    <p class="text-muted">Click on the first lesson in the sidebar to begin.</p>
                </div>
            @endif

            <hr class="my-5">

            <!-- Course Q&A Section -->
            <div>
                <h3 class="fw-bold mb-4">Course Discussion</h3>
                
                <form action="{{ route('student.questions.ask', $course) }}" method="POST" class="mb-5">
                    @csrf
                    <div class="mb-3">
                        <textarea name="content" class="form-control bg-light border-0" rows="3" placeholder="Have a question about this course? Ask the coach!" required></textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">Post Question</button>
                    </div>
                </form>

                <div class="qa-list">
                    @forelse($questions as $question)
                    <div class="glass-card p-4 mb-4">
                        <div class="d-flex mb-3">
                            <img src="{{ $question->user->avatar ?? 'https://ui-avatars.com/api/?name='.$question->user->name }}" class="profile-img me-3" style="width: 40px; height: 40px;">
                            <div>
                                <div class="fw-bold">{{ $question->user->name }} <small class="text-muted fw-normal ms-2">{{ $question->created_at->diffForHumans() }}</small></div>
                                <p class="mb-0 mt-1">{{ $question->content }}</p>
                            </div>
                        </div>
                        
                        <!-- Replies -->
                        @if($question->replies->count() > 0)
                            <div class="ms-5 mt-4">
                                @foreach($question->replies as $reply)
                                <div class="d-flex mb-3">
                                    <img src="{{ $reply->user->avatar ?? 'https://ui-avatars.com/api/?name='.$reply->user->name }}" class="profile-img me-3" style="width: 35px; height: 35px;">
                                    <div class="bg-light p-3 rounded-4 w-100">
                                        <div class="fw-bold text-primary">{{ $reply->user->name }} <span class="badge bg-primary ms-1">Coach</span> <small class="text-muted fw-normal ms-2 text-dark">{{ $reply->created_at->diffForHumans() }}</small></div>
                                        <p class="mb-0 mt-1">{{ $reply->content }}</p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    @empty
                    <p class="text-muted text-center py-4">No questions yet. Be the first to ask!</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .accordion-button:not(.collapsed) {
        color: var(--primary);
        box-shadow: none;
    }
    .accordion-item:last-of-type {
        border-bottom: 0;
    }
    .list-group-item.active {
        background: linear-gradient(135deg, #6366f1, #8b5cf6);
        color: white;
    }
</style>
@endsection
