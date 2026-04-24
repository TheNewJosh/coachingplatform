<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Progress;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $enrolledCourses = $user->enrolledCourses()->get();
        
        foreach ($enrolledCourses as $course) {
            $totalLessons = $course->lessons()->count();
            $completedLessons = $user->progress()->whereIn('lesson_id', $course->lessons()->pluck('lessons.id'))->count();
            $course->progress_percent = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
            $course->lessons_count = $totalLessons;
        }

        $enrolledCourseIds = $enrolledCourses->pluck('id')->toArray();
        $exploreCourses = Course::whereNotIn('id', $enrolledCourseIds)->inRandomOrder()->take(2)->get();
        return view('student.dashboard', compact('enrolledCourses', 'exploreCourses'));
    }

    public function catalog()
    {
        $courses = Course::with('coach')->get();
        return view('student.catalog', compact('courses'));
    }

    public function courseDetails(Course $course)
    {
        $course->load(['coach', 'modules.lessons']);
        $isEnrolled = auth()->user()->enrolledCourses()->where('course_id', $course->id)->exists();
        return view('student.courses.details', compact('course', 'isEnrolled'));
    }

    public function enroll(Course $course)
    {
        if (!auth()->user()->enrolledCourses()->where('course_id', $course->id)->exists()) {
            auth()->user()->enrollments()->create(['course_id' => $course->id]);
        }
        return redirect()->route('student.dashboard')->with('success', 'Enrolled successfully!');
    }

    public function showCourse(Course $course)
    {
        $course->load('modules.lessons');
        $questions = $course->questions()->with(['user', 'replies.user'])->whereNull('parent_id')->get();
        return view('student.courses.show', compact('course', 'questions'));
    }

    public function showLesson(Course $course, Lesson $lesson)
    {
        $course->load('modules.lessons');
        $questions = $course->questions()->with(['user', 'replies.user'])->whereNull('parent_id')->get();
        return view('student.courses.show', compact('course', 'lesson', 'questions'));
    }

    public function completeLesson(Lesson $lesson)
    {
        $user = auth()->user();
        Progress::firstOrCreate([
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
        ], [
            'completed_at' => now(),
        ]);

        // Check for course completion to award badge
        $course = clone $lesson->module->course;
        $totalLessons = $course->lessons()->count();
        $completedLessons = $user->progress()->whereIn('lesson_id', $course->lessons()->pluck('lessons.id'))->count();

        if ($totalLessons > 0 && $completedLessons >= $totalLessons) {
            // Auto-generate default badge if coach hasn't set one
            if (!$course->badge) {
                $course->badge()->create([
                    'name' => 'Certified: ' . $course->title,
                    'description' => 'Successfully completed the ' . $course->title . ' course.',
                ]);
                $course->load('badge');
            }

            if ($course->badge && !$user->badges()->where('badge_id', $course->badge->id)->exists()) {
                $user->badges()->attach($course->badge->id);
                return back()->with('success', 'Lesson marked as completed! 🎉 You also earned the "' . $course->badge->name . '" badge!');
            }
        }

        return back()->with('success', 'Lesson marked as completed!');
    }

    public function askQuestion(Request $request, Course $course)
    {
        $request->validate(['content' => 'required|string']);
        
        $course->questions()->create([
            'user_id' => auth()->id(),
            'content' => $request->content,
            'lesson_id' => null
        ]);

        return back()->with('success', 'Question posted successfully!');
    }

    public function certificate(Course $course)
    {
        $user = auth()->user();
        $totalLessons = $course->lessons()->count();
        $completedLessons = $user->progress()->whereIn('lesson_id', $course->lessons()->pluck('lessons.id'))->count();

        if ($totalLessons == 0 || $completedLessons < $totalLessons) {
            return redirect()->route('student.dashboard')->with('error', 'You must complete the course to view your certificate.');
        }

        return view('student.courses.certificate', compact('course', 'user'));
    }
}
