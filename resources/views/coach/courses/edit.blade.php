@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="glass-card p-4 sticky-top" style="top: 100px;">
            <h4 class="fw-bold mb-4">Course Settings</h4>
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link active mb-2 text-start" id="v-pills-info-tab" data-bs-toggle="pill" data-bs-target="#v-pills-info" type="button">General Information</button>
                <button class="nav-link mb-2 text-start" id="v-pills-content-tab" data-bs-toggle="pill" data-bs-target="#v-pills-content" type="button">Curriculum Builder</button>
                <button class="nav-link mb-2 text-start" id="v-pills-badge-tab" data-bs-toggle="pill" data-bs-target="#v-pills-badge" type="button">Completion Badge</button>
                <button class="nav-link mb-2 text-start" id="v-pills-discussions-tab" data-bs-toggle="pill" data-bs-target="#v-pills-discussions" type="button">Course Discussions</button>
                <a href="{{ route('coach.courses.students', $course) }}" class="nav-link mb-2 text-start">Student Monitoring</a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="tab-content" id="v-pills-tabContent">
            <!-- General Info -->
            <div class="tab-pane fade show active" id="v-pills-info" role="tabpanel">
                <div class="glass-card p-5 animate-up">
                    <h3 class="fw-bold mb-4">General Information</h3>
                    <form action="{{ route('coach.courses.update', $course) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-medium">Course Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $course->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium">Description</label>
                            <textarea name="description" class="form-control" rows="5" required>{{ $course->description }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-medium">Thumbnail</label>
                            @if($course->thumbnail)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $course->thumbnail) }}" class="img-thumbnail" style="max-height: 150px;">
                                </div>
                            @endif
                            <input type="file" name="thumbnail" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>

            <!-- Curriculum Builder -->
            <div class="tab-pane fade" id="v-pills-content" role="tabpanel">
                <div class="glass-card p-5 animate-up">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-bold mb-0">Curriculum Builder</h3>
                        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModuleModal">Add Module</button>
                    </div>

                    @foreach($course->modules as $module)
                    <div class="card bg-light border-0 rounded-4 mb-4">
                        <div class="card-header bg-transparent border-0 p-4 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0">{{ $module->title }}</h5>
                            <div>
                                <button class="btn btn-sm btn-outline-secondary me-1" data-bs-toggle="modal" data-bs-target="#editModuleModal{{ $module->id }}"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-outline-danger me-2" data-bs-toggle="modal" data-bs-target="#deleteModuleModal{{ $module->id }}"><i class="fas fa-trash"></i></button>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addLessonModal{{ $module->id }}">Add Lesson</button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach($module->lessons as $lesson)
                                <div class="list-group-item bg-transparent border-0 border-top p-3 d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-{{ $lesson->type == 'video' ? 'video' : ($lesson->type == 'audio' ? 'volume-up' : ($lesson->type == 'youtube' ? 'play-circle' : 'file-alt')) }} me-2 text-primary"></i>
                                        <span>{{ $lesson->title }}</span>
                                        <span class="badge bg-light text-dark ms-2">{{ ucfirst($lesson->type) }}</span>
                                    </div>
                                    <div>
                                        <button class="btn btn-sm btn-link text-secondary p-0 me-2" data-bs-toggle="modal" data-bs-target="#editLessonModal{{ $lesson->id }}"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-link text-danger p-0" data-bs-toggle="modal" data-bs-target="#deleteLessonModal{{ $lesson->id }}"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Completion Badge -->
            <div class="tab-pane fade" id="v-pills-badge" role="tabpanel">
                <div class="glass-card p-5 animate-up">
                    <h3 class="fw-bold mb-4">Completion Badge</h3>
                    <p class="text-muted mb-4">Set up a badge that students will receive upon completing all lessons in this course.</p>
                    
                    <form action="{{ route('coach.badges.store', $course) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-medium">Badge Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $course->badge->name ?? '' }}" placeholder="e.g. Master of Leadership" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium">Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="What does this badge signify?">{{ $course->badge->description ?? '' }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-medium">Badge Icon (Image)</label>
                            @if($course->badge && $course->badge->icon)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $course->badge->icon) }}" class="rounded-circle shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                                </div>
                            @endif
                            <input type="file" name="icon" class="form-control" accept="image/*" {{ $course->badge ? '' : 'required' }}>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ $course->badge ? 'Update Badge' : 'Create Badge' }}</button>
                    </form>
                </div>
            </div>

            <!-- Course Discussions -->
            <div class="tab-pane fade" id="v-pills-discussions" role="tabpanel">
                <div class="glass-card p-5 animate-up">
                    <h3 class="fw-bold mb-4">Course Discussions</h3>
                    <p class="text-muted mb-4">View and respond to questions asked by students in this course.</p>
                    
                    <div class="qa-list">
                        @forelse($course->questions as $question)
                            <div class="mb-4 pb-4 border-bottom">
                                <div class="d-flex align-items-center mb-2">
                                    <img src="{{ $question->user->avatar ?? 'https://ui-avatars.com/api/?name='.$question->user->name }}" class="profile-img me-2" style="width: 30px; height: 30px;">
                                    <div class="fw-bold small">{{ $question->user->name }}</div>
                                    <small class="text-muted ms-auto">{{ $question->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="small text-dark mb-3">{{ $question->content }}</p>
                                
                                <!-- Replies -->
                                @if($question->replies->count() > 0)
                                    <div class="ms-4 mt-3 mb-3 border-start border-2 border-primary ps-3">
                                        @foreach($question->replies as $reply)
                                        <div class="mb-2">
                                            <div class="fw-bold small text-primary">{{ $reply->user->name }} <span class="badge bg-primary ms-1">Coach</span> <small class="text-muted fw-normal ms-2 text-dark">{{ $reply->created_at->diffForHumans() }}</small></div>
                                            <p class="small mb-0 mt-1">{{ $reply->content }}</p>
                                        </div>
                                        @endforeach
                                    </div>
                                @endif

                                <form action="{{ route('coach.questions.reply', $question) }}" method="POST" class="mt-2">
                                    @csrf
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="content" class="form-control bg-light border-0" placeholder="Write a reply..." required>
                                        <button class="btn btn-primary" type="submit">Reply</button>
                                    </div>
                                </form>
                            </div>
                        @empty
                            <p class="text-muted text-center py-4 mb-0">No questions asked yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ALL MODALS AT THE BOTTOM TO PREVENT Z-INDEX ISSUES -->

<!-- Add Module Modal -->
<div class="modal fade" id="addModuleModal" tabindex="-1">
    <div class="modal-dialog glass-card p-0 border-0 overflow-hidden">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-header border-0 p-4">
                <h5 class="fw-bold mb-0">Add New Module</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('coach.modules.store', $course) }}" method="POST">
                @csrf
                <div class="modal-body p-4 pt-0">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Module Title</label>
                        <input type="text" name="title" class="form-control" required placeholder="e.g. Introduction">
                    </div>
                </div>
                <div class="modal-footer border-0 p-4">
                    <button type="submit" class="btn btn-primary w-100">Add Module</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($course->modules as $module)
    <!-- Edit Module Modal -->
    <div class="modal fade" id="editModuleModal{{ $module->id }}" tabindex="-1">
        <div class="modal-dialog glass-card p-0 border-0 overflow-hidden">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-header border-0 p-4">
                    <h5 class="fw-bold mb-0">Edit Module</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('coach.modules.update', $module) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4 pt-0">
                        <div class="mb-3">
                            <label class="form-label fw-medium">Module Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $module->title }}" required>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4">
                        <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Module Modal -->
    <div class="modal fade" id="deleteModuleModal{{ $module->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('coach.modules.destroy', $module) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body p-4 text-center">
                        <h5 class="fw-bold mb-3">Delete Module?</h5>
                        <p class="text-muted">Are you sure you want to delete "{{ $module->title }}"? This will also delete all lessons inside it. This cannot be undone.</p>
                        <div class="d-flex gap-2 justify-content-center">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Lesson Modal -->
    <div class="modal fade" id="addLessonModal{{ $module->id }}" tabindex="-1">
        <div class="modal-dialog glass-card p-0 border-0 overflow-hidden">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-header border-0 p-4">
                    <h5 class="fw-bold mb-0">Add Lesson to {{ $module->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('coach.lessons.store', $module) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4 pt-0">
                        <div class="mb-3">
                            <label class="form-label fw-medium">Lesson Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-medium">Type</label>
                            <select name="type" class="form-select" onchange="toggleLessonFields(this, {{ $module->id }})" required>
                                <option value="text">Text Content</option>
                                <option value="video">Video Upload</option>
                                <option value="audio">Audio Upload</option>
                                <option value="youtube">YouTube Link</option>
                            </select>
                        </div>
                        <div id="textField{{ $module->id }}">
                            <div class="mb-3">
                                <label class="form-label fw-medium">Content</label>
                                <textarea name="content" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                        <div id="fileField{{ $module->id }}" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label fw-medium">Upload File</label>
                                <input type="file" name="media_file" class="form-control">
                            </div>
                        </div>
                        <div id="urlField{{ $module->id }}" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label fw-medium">YouTube URL</label>
                                <input type="url" name="media_url" class="form-control" placeholder="https://youtube.com/watch?v=...">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4">
                        <button type="submit" class="btn btn-primary w-100">Add Lesson</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach($module->lessons as $lesson)
        <!-- Edit Lesson Modal -->
        <div class="modal fade" id="editLessonModal{{ $lesson->id }}" tabindex="-1">
            <div class="modal-dialog glass-card p-0 border-0 overflow-hidden">
                <div class="modal-content bg-transparent border-0">
                    <div class="modal-header border-0 p-4">
                        <h5 class="fw-bold mb-0">Edit Lesson: {{ $lesson->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('coach.lessons.update', $lesson) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body p-4 pt-0">
                            <div class="mb-3">
                                <label class="form-label fw-medium">Lesson Title</label>
                                <input type="text" name="title" class="form-control" value="{{ $lesson->title }}" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium">Type</label>
                                <select name="type" class="form-select" onchange="toggleEditLessonFields(this, {{ $lesson->id }})" required>
                                    <option value="text" {{ $lesson->type == 'text' ? 'selected' : '' }}>Text Content</option>
                                    <option value="video" {{ $lesson->type == 'video' ? 'selected' : '' }}>Video Upload</option>
                                    <option value="audio" {{ $lesson->type == 'audio' ? 'selected' : '' }}>Audio Upload</option>
                                    <option value="youtube" {{ $lesson->type == 'youtube' ? 'selected' : '' }}>YouTube Link</option>
                                </select>
                            </div>
                            <div id="editTextField{{ $lesson->id }}" style="display: {{ $lesson->type == 'text' ? 'block' : 'none' }};">
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Content</label>
                                    <textarea name="content" class="form-control" rows="4">{{ $lesson->content }}</textarea>
                                </div>
                            </div>
                            <div id="editFileField{{ $lesson->id }}" style="display: {{ in_array($lesson->type, ['video', 'audio']) ? 'block' : 'none' }};">
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Upload File (Leave blank to keep existing)</label>
                                    <input type="file" name="media_file" class="form-control">
                                    @if(in_array($lesson->type, ['video', 'audio']) && $lesson->media_url)
                                        <small class="text-muted d-block mt-1">Current file uploaded.</small>
                                    @endif
                                </div>
                            </div>
                            <div id="editUrlField{{ $lesson->id }}" style="display: {{ $lesson->type == 'youtube' ? 'block' : 'none' }};">
                                <div class="mb-3">
                                    <label class="form-label fw-medium">YouTube URL</label>
                                    <input type="url" name="media_url" class="form-control" value="{{ $lesson->type == 'youtube' ? $lesson->media_url : '' }}" placeholder="https://youtube.com/watch?v=...">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 p-4">
                            <button type="submit" class="btn btn-primary w-100">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Lesson Modal -->
        <div class="modal fade" id="deleteLessonModal{{ $lesson->id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('coach.lessons.destroy', $lesson) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body p-4 text-center">
                            <h5 class="fw-bold mb-3">Delete Lesson?</h5>
                            <p class="text-muted">Are you sure you want to delete "{{ $lesson->title }}"? This cannot be undone.</p>
                            <div class="d-flex gap-2 justify-content-center">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endforeach

<script>
function toggleLessonFields(select, id) {
    const text = document.getElementById('textField' + id);
    const file = document.getElementById('fileField' + id);
    const url = document.getElementById('urlField' + id);
    
    text.style.display = 'none';
    file.style.display = 'none';
    url.style.display = 'none';
    
    if (select.value === 'text') text.style.display = 'block';
    else if (select.value === 'youtube') url.style.display = 'block';
    else file.style.display = 'block';
}

function toggleEditLessonFields(select, id) {
    const text = document.getElementById('editTextField' + id);
    const file = document.getElementById('editFileField' + id);
    const url = document.getElementById('editUrlField' + id);
    
    text.style.display = 'none';
    file.style.display = 'none';
    url.style.display = 'none';
    
    if (select.value === 'text') text.style.display = 'block';
    else if (select.value === 'youtube') url.style.display = 'block';
    else file.style.display = 'block';
}
</script>
@endsection
