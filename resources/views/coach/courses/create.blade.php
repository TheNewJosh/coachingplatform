@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="glass-card p-5 animate-up">
            <h2 class="fw-bold mb-4">Create New Course</h2>
            
            <form action="{{ route('coach.courses.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-medium">Course Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" placeholder="e.g. Mastering Modern Leadership" value="{{ old('title') }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-medium">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="What will students learn in this course?" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label class="form-label fw-medium">Thumbnail Image</label>
                    <input type="file" name="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror">
                    <div class="form-text">Recommended size: 800x600px. Max 2MB.</div>
                    @error('thumbnail')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4">Create Course</button>
                    <a href="{{ route('coach.dashboard') }}" class="btn btn-light border px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
