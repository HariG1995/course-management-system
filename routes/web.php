<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EnrollmentController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login', [AuthController::class, 'userLogin'])->name('login');
Route::post('/check-login', [AuthController::class, 'checkLogin'])->name('check_login');
Route::post('/logout', [AuthController::class, 'userLogout'])->name('logout');

Route::middleware('auth')->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('home');

    Route::resource('categories', CategoryController::class);
    Route::resource('students', StudentController::class);
    Route::resource('courses', CourseController::class);

    Route::get('/courses/{courseId}/students', [CourseController::class, 'studentsByCourse'])->name('students_by_course');
    Route::get('/courses/filter', [CourseController::class, 'filter'])->name('filter_course');

    Route::get('/enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'store'])->name('enrollments.store');
    Route::delete('/enrollments/{enrollment}', [EnrollmentController::class, 'destroy'])->name('enrollments.destroy');

    // API LIST
    Route::get('/coursesFilter', [CourseController::class, 'filterApi']);
    Route::get('/coursesList', [CourseController::class, 'coursesApi']);
});