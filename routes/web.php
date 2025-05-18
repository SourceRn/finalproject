<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsTeacher;
use App\Http\Middleware\IsStudent;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\QuestionController;

Route::view('/', 'welcome');

Route::get('/dashboard', function () {
    $role = Auth::user()->role;

    return match ($role) {
        'admin' => redirect()->route('admin.dashboard'),
        'teacher' => redirect()->route('teacher.dashboard'),
        'student' => redirect()->route('student.dashboard'),
        default => view('dashboard'), // o redirect()->route('user.dashboard')
    };
})->middleware(['auth'])->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', IsAdmin::class])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

Route::middleware(['auth', IsTeacher::class])->group(function () {
    Route::get('/teacher/dashboard', function () {
        return view('teacher.dashboard');
    })->name('teacher.dashboard');
});

Route::middleware(['auth'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/exams', [ExamController::class, 'index'])->name('exams.index');
    Route::get('/exams/create', [ExamController::class, 'create'])->name('exams.create');
    Route::post('/exams', [ExamController::class, 'store'])->name('exams.store');
    Route::delete('/exams/{exam}', [ExamController::class, 'destroy'])->name('exams.destroy');

    // Preguntas
    Route::get('/exams/{exam}/questions', [QuestionController::class, 'index'])->name('exams.questions.index');
    Route::get('/exams/{exam}/questions/create', [QuestionController::class, 'create'])->name('exams.questions.create');
    Route::post('/exams/{exam}/questions', [QuestionController::class, 'store'])->name('exams.questions.store');
    Route::get('/exams/{exam}/questions/{question}/edit', [QuestionController::class, 'edit'])->name('exams.questions.edit');
    Route::put('/exams/{exam}/questions/{question}', [QuestionController::class, 'update'])->name('exams.questions.update');
    Route::delete('/exams/{exam}/questions/{question}', [QuestionController::class, 'destroy'])->name('exams.questions.destroy');

    // Entregas
    Route::get('/exams/{exam}/submissions', [ExamController::class, 'submissions'])->name('exams.submissions');
    Route::get('/exams/{exam}/submissions/{submission}', [ExamController::class, 'showSubmission'])->name('exams.submissions.show');
});

Route::middleware(['auth', IsStudent::class])->group(function () {
    Route::get('/student/dashboard', function () {
        return view('student.dashboard');
    })->name('student.dashboard');
});

require __DIR__.'/auth.php';
