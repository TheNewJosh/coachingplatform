<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Seeder;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $coach = User::where('role', 'coach')->first();

        if (!$coach) return;

        $course = Course::create([
            'title' => 'Mastering Modern Leadership',
            'description' => 'A comprehensive guide to leading remote and hybrid teams in the digital age.',
            'coach_id' => $coach->id,
        ]);

        $module1 = Module::create([
            'course_id' => $course->id,
            'title' => 'Foundation of Trust',
            'order' => 1,
        ]);

        Lesson::create([
            'module_id' => $module1->id,
            'title' => 'The Science of Connection',
            'content' => 'In this lesson, we explore how oxytocin builds trust in professional settings...',
            'order' => 1,
        ]);

        Lesson::create([
            'module_id' => $module1->id,
            'title' => 'Psychological Safety',
            'content' => 'Creating an environment where everyone feels safe to speak up...',
            'order' => 2,
        ]);

        $module2 = Module::create([
            'course_id' => $course->id,
            'title' => 'Effective Communication',
            'order' => 2,
        ]);

        Lesson::create([
            'module_id' => $module2->id,
            'title' => 'Active Listening',
            'content' => 'Listening is more than just hearing words...',
            'order' => 1,
        ]);
    }
}
