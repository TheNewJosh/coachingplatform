@extends('layouts.app')

@section('content')
<div class="glass-card p-5 animate-up">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Student Monitoring</h2>
            <p class="text-muted">{{ $course->title }}</p>
        </div>
        <a href="{{ route('coach.courses.edit', $course) }}" class="btn btn-light border btn-sm">Back to Editor</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr class="text-muted">
                    <th>Student</th>
                    <th>Enrolled At</th>
                    <th>Progress</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $totalLessons = $course->lessons()->count(); @endphp
                @foreach($students as $student)
                @php 
                    $completed = $student->progress_count;
                    $percent = $totalLessons > 0 ? round(($completed / $totalLessons) * 100) : 0;
                @endphp
                <tr>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="{{ $student->avatar ?? 'https://ui-avatars.com/api/?name='.$student->name }}" class="profile-img me-3">
                            <div>
                                <div class="fw-bold">{{ $student->name }}</div>
                                <div class="text-muted small">{{ $student->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-muted">{{ $student->pivot->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="d-flex align-items-center" style="width: 200px;">
                            <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                <div class="progress-bar bg-primary" style="width: {{ $percent }}%;"></div>
                            </div>
                            <small class="fw-bold">{{ $percent }}%</small>
                        </div>
                    </td>
                    <td>
                        <span class="badge rounded-pill bg-{{ $percent == 100 ? 'success' : 'primary' }}">
                            {{ $percent == 100 ? 'Completed' : 'Learning' }}
                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#rewardModal{{ $student->id }}">
                            <i class="fas fa-gift"></i> Reward
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- ALL MODALS AT THE BOTTOM TO PREVENT Z-INDEX ISSUES -->
@foreach($students as $student)
<!-- Reward Modal -->
<div class="modal fade" id="rewardModal{{ $student->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content text-start">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Give Reward to {{ $student->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('coach.students.rewards.store', $student) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-medium">Reward Name (e.g., Gift Won)</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Message</label>
                        <textarea name="message" class="form-control" rows="3" placeholder="e.g., This gift has been shipped to you..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-medium">Image of Gift (Optional)</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send Reward</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection
