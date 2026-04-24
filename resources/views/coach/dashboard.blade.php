@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="glass-card p-5 animate-up">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="fw-bold">Coach Dashboard</h1>
                    <p class="text-muted">Manage your courses and support your students.</p>
                </div>
                <a href="{{ route('coach.courses.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i> Create New Course</a>
            </div>
            
            <div class="row">
                <div class="col-md-8">
                    <h4 class="fw-bold mb-3">Your Courses</h4>
                    @forelse($courses as $course)
                    <div class="glass-card p-4 mb-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded-3 p-4 me-3">
                                <i class="fas fa-laptop-code text-white fs-3"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fw-bold mb-1">{{ $course->title }}</h5>
                                <p class="text-muted mb-0">{{ $course->modules_count ?? 0 }} Modules • {{ $course->students_count }} Students enrolled</p>
                            </div>
                            <a href="{{ route('coach.courses.edit', $course) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                        </div>
                    </div>
                    @empty
                    <div class="glass-card p-5 text-center">
                        <p class="text-muted">You haven't created any courses yet.</p>
                        <a href="{{ route('coach.courses.create') }}" class="btn btn-primary">Create Your First Course</a>
                    </div>
                    @endforelse
                </div>
                <div class="col-md-4">
                    <h4 class="fw-bold mb-3">Recent Questions</h4>
                    <div class="glass-card p-4">
                        @forelse($questions as $question)
                            <div class="mb-4 pb-4 border-bottom">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="{{ $question->user->avatar ?? 'https://ui-avatars.com/api/?name='.$question->user->name }}" class="profile-img me-2" style="width: 30px; height: 30px;">
                                    <div class="fw-bold small">{{ $question->user->name }}</div>
                                    <small class="text-muted ms-auto">{{ $question->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="small mb-2 fw-medium text-primary">{{ $question->course->title }} {{ $question->lesson ? '- ' . $question->lesson->title : '' }}</p>
                                <p class="small text-muted mb-3">{{ $question->content }}</p>
                                
                                <form action="{{ route('coach.questions.reply', $question) }}" method="POST">
                                    @csrf
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="content" class="form-control" placeholder="Write a reply..." required>
                                        <button class="btn btn-primary" type="submit">Reply</button>
                                    </div>
                                </form>
                            </div>
                        @empty
                            <p class="text-muted text-center py-4 mb-0">No pending questions.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
