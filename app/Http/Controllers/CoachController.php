<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    public function dashboard()
    {
        $courses = auth()->user()->coachedCourses()->withCount(['students', 'modules'])->get();
        
        $courseIds = $courses->pluck('id');
        $questions = \App\Models\Question::with(['user', 'lesson', 'course'])
            ->whereIn('course_id', $courseIds)
            ->whereNull('parent_id')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('coach.dashboard', compact('courses', 'questions'));
    }

    public function createCourse()
    {
        return view('coach.courses.create');
    }

    public function storeCourse(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('courses', 'public');
        }

        auth()->user()->coachedCourses()->create($data);

        return redirect()->route('coach.dashboard')->with('success', 'Course created successfully.');
    }

    public function editCourse(Course $course)
    {
        $this->authorizeCoach($course);
        $course->load(['modules.lessons', 'questions' => function ($query) {
            $query->whereNull('parent_id')->with(['user', 'replies.user'])->latest();
        }]);
        return view('coach.courses.edit', compact('course'));
    }

    public function updateCourse(Request $request, Course $course)
    {
        $this->authorizeCoach($course);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('courses', 'public');
        }

        $course->update($data);

        return back()->with('success', 'Course updated successfully.');
    }

    public function storeModule(Request $request, Course $course)
    {
        $this->authorizeCoach($course);
        $request->validate(['title' => 'required|string|max:255']);
        
        $course->modules()->create([
            'title' => $request->title,
            'order' => $course->modules()->count() + 1
        ]);

        return back()->with('success', 'Module added successfully.');
    }

    public function storeLesson(Request $request, \App\Models\Module $module)
    {
        $this->authorizeCoach($module->course);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:text,video,audio,youtube',
            'content' => 'nullable|string',
            'media_url' => 'nullable|string',
            'media_file' => 'nullable|file|max:51200', // 50MB
        ]);

        if ($request->hasFile('media_file')) {
            $data['media_url'] = $request->file('media_file')->store('lessons', 'public');
        }

        $module->lessons()->create([
            'title' => $data['title'],
            'type' => $data['type'],
            'content' => $data['content'],
            'media_url' => $data['media_url'] ?? $data['media_url'],
            'order' => $module->lessons()->count() + 1
        ]);

        return back()->with('success', 'Lesson added successfully.');
    }

    public function updateModule(Request $request, \App\Models\Module $module)
    {
        $this->authorizeCoach($module->course);
        $request->validate(['title' => 'required|string|max:255']);
        $module->update(['title' => $request->title]);
        return back()->with('success', 'Module updated successfully.');
    }

    public function destroyModule(\App\Models\Module $module)
    {
        $this->authorizeCoach($module->course);
        $module->delete();
        return back()->with('success', 'Module deleted successfully.');
    }

    public function updateLesson(Request $request, \App\Models\Lesson $lesson)
    {
        $this->authorizeCoach($lesson->module->course);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:text,video,audio,youtube',
            'content' => 'nullable|string',
            'media_url' => 'nullable|string',
            'media_file' => 'nullable|file|max:51200',
        ]);

        if ($request->hasFile('media_file')) {
            $data['media_url'] = $request->file('media_file')->store('lessons', 'public');
        }

        $lesson->update([
            'title' => $data['title'],
            'type' => $data['type'],
            'content' => $data['content'],
            'media_url' => $data['media_url'] ?? $lesson->media_url,
        ]);

        return back()->with('success', 'Lesson updated successfully.');
    }

    public function destroyLesson(\App\Models\Lesson $lesson)
    {
        $this->authorizeCoach($lesson->module->course);
        $lesson->delete();
        return back()->with('success', 'Lesson deleted successfully.');
    }

    public function students(Course $course)
    {
        $this->authorizeCoach($course);
        $students = $course->students()->withCount(['progress' => function($q) use($course) {
            $q->whereIn('lesson_id', $course->lessons()->pluck('lessons.id'));
        }])->get();
        
        return view('coach.courses.students', compact('course', 'students'));
    }

    public function replyToQuestion(Request $request, \App\Models\Question $question)
    {
        $request->validate(['content' => 'required|string']);
        
        \App\Models\Question::create([
            'user_id' => auth()->id(),
            'course_id' => $question->course_id,
            'content' => $request->content,
            'parent_id' => $question->id
        ]);

        return back()->with('success', 'Response sent!');
    }

    public function giveReward(Request $request, \App\Models\User $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('rewards', 'public');
        }

        $student->rewards()->create([
            'coach_id' => auth()->id(),
            'name' => $request->name,
            'message' => $request->message,
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Reward given successfully!');
    }

    public function storeBadge(Request $request, Course $course)
    {
        $this->authorizeCoach($course);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('badges', 'public');
        }

        if ($course->badge) {
            $course->badge()->update($data);
        } else {
            $course->badge()->create($data);
        }

        return back()->with('success', 'Badge saved successfully.');
    }

    private function authorizeCoach(Course $course)
    {
        if ($course->coach_id !== auth()->id()) {
            abort(403);
        }
    }
}
