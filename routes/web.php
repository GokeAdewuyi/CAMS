<?php

use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\StudentController;
use App\Http\Livewire\Assessment;
use App\Http\Livewire\Course;
use App\Http\Livewire\Curriculum;
use App\Http\Livewire\Lecturer;
use App\Http\Livewire\Semester;
use App\Http\Livewire\Student;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::get('/lecturers', Lecturer::class)->name('lecturers');
    Route::get('/lecturers/course/{course}/semester/{semester}', [CourseController::class, 'fetchLecturers']);

    Route::get('/curricula', Curriculum::class)->name('curricula');

    Route::get('/semesters', Semester::class)->name('semesters');
    Route::put('/semesters/{semester}', [SemesterController::class, 'update'])->name('semesters.update');
    Route::post('/semesters', [SemesterController::class, 'set'])->name('semesters.set');

    Route::get('/courses', Course::class)->name('courses');
    Route::post('/courses', [CourseController::class, 'allocate'])->name('courses.allocate');

    Route::prefix('students')->name('students')->group(function () {
        Route::get('/', Student::class);
        Route::get('/upload', [Student::class, 'upload'])->name('.upload');
        Route::post('/upload', [StudentController::class, 'process'])->name('.process');
        Route::get('/template/download', [StudentController::class, 'template'])->name('.template');
    });

    Route::prefix('assessments')->name('assessments')->group(function () {
        Route::get('/', Assessment::class);
        Route::get('/upload', [Assessment::class, 'upload'])->name('.upload');
        Route::post('/upload', [AssessmentController::class, 'process'])->name('.process');
        Route::delete('/{result}', [AssessmentController::class, 'delete'])->name('.delete');
        Route::get('/template/download', [AssessmentController::class, 'template'])->name('.template');
        Route::get('/report/download', [AssessmentController::class, 'report'])->name('.report');
    });
});
