<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StudentController;
use App\Models\Course;
use App\Models\Registration;
use App\Models\Student;

Route::redirect('/', '/dashboard');
Route::middleware('guest')->group(function () { Route::get('/login', [AuthController::class, 'showLogin'])->name('login'); Route::post('/login', [AuthController::class, 'login'])->name('login.store'); });
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () { return view('dashboard', ['studentCount' => Student::count(), 'courseCount' => Course::count(), 'registrationCount' => Registration::count()]); })->name('dashboard');
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/registrations', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::post('/registrations', [RegistrationController::class, 'store'])->name('registrations.store');
    Route::middleware('role:student')->group(function () { Route::get('/registrations/create', [RegistrationController::class, 'create'])->name('registrations.create'); });
    Route::middleware('role:admin')->group(function () { Route::resource('students', StudentController::class)->except('show'); Route::resource('courses', CourseController::class)->except(['index', 'show']); Route::get('/admin/registrations/create', [RegistrationController::class, 'create'])->name('admin.registrations.create'); Route::delete('/registrations/{registration}', [RegistrationController::class, 'destroy'])->name('registrations.destroy'); });
});
