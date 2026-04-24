<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Password Reset
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Role-Based Dashboards
Route::middleware(['auth'])->group(function () {
    
    // Student Dashboard
    Route::middleware(['role:student'])->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
        Route::get('/catalog', [StudentController::class, 'catalog'])->name('catalog');
        Route::get('/courses/{course}/details', [StudentController::class, 'courseDetails'])->name('courses.details');
        Route::post('/courses/{course}/enroll', [StudentController::class, 'enroll'])->name('enroll');
        Route::get('/courses/{course}', [StudentController::class, 'showCourse'])->name('courses.show');
        Route::get('/courses/{course}/lessons/{lesson}', [StudentController::class, 'showLesson'])->name('lessons.show');
        Route::post('/lessons/{lesson}/complete', [StudentController::class, 'completeLesson'])->name('lessons.complete');
        Route::post('/courses/{course}/questions', [StudentController::class, 'askQuestion'])->name('questions.ask');
        Route::get('/courses/{course}/certificate', [StudentController::class, 'certificate'])->name('courses.certificate');
    });

    // Coach Dashboard
    Route::middleware(['role:coach'])->prefix('coach')->name('coach.')->group(function () {
        Route::get('/dashboard', [CoachController::class, 'dashboard'])->name('dashboard');
        Route::get('/courses/create', [CoachController::class, 'createCourse'])->name('courses.create');
        Route::post('/courses', [CoachController::class, 'storeCourse'])->name('courses.store');
        Route::get('/courses/{course}/edit', [CoachController::class, 'editCourse'])->name('courses.edit');
        Route::put('/courses/{course}', [CoachController::class, 'updateCourse'])->name('courses.update');
        Route::get('/courses/{course}/students', [CoachController::class, 'students'])->name('courses.students');
        Route::post('/students/{student}/rewards', [CoachController::class, 'giveReward'])->name('students.rewards.store');
        
        // Module & Lesson Management
        Route::post('/courses/{course}/modules', [CoachController::class, 'storeModule'])->name('modules.store');
        Route::put('/modules/{module}', [CoachController::class, 'updateModule'])->name('modules.update');
        Route::delete('/modules/{module}', [CoachController::class, 'destroyModule'])->name('modules.destroy');
        
        Route::post('/modules/{module}/lessons', [CoachController::class, 'storeLesson'])->name('lessons.store');
        Route::put('/lessons/{lesson}', [CoachController::class, 'updateLesson'])->name('lessons.update');
        Route::delete('/lessons/{lesson}', [CoachController::class, 'destroyLesson'])->name('lessons.destroy');
        
        Route::post('/courses/{course}/badges', [CoachController::class, 'storeBadge'])->name('badges.store');
        
        // Q&A Response
        Route::post('/questions/{question}/reply', [CoachController::class, 'replyToQuestion'])->name('questions.reply');
    });

    // Admin Dashboard
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    });

});
