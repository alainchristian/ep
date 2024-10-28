<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\EPController;
use App\Http\Controllers\RotationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\TeacherEPController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin routes
    Route::group(['middleware' => function ($request, $next) {
        if (Auth::check() && Auth::user()->Role === 'Admin') {
            return $next($request);
        }
        abort(403, 'Unauthorized action.');
    }], function () {
        Route::resource('students', StudentController::class);
        Route::resource('families', FamilyController::class);
        Route::resource('eps', EPController::class);
        Route::resource('rotations', RotationController::class);
        Route::resource('users', UserController::class);
    });

    // Teacher routes
    Route::group(['middleware' => function ($request, $next) {
        if (Auth::check() && Auth::user()->Role === 'Teacher') {
            return $next($request);
        }
        abort(403, 'Unauthorized action.');
    }], function () {
        Route::get('/my-eps', [TeacherEPController::class, 'index'])->name('my-eps.index');
        Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    });

    // Report routes (accessible by both Admin and Teacher)
    Route::get('/reports/attendance', [ReportController::class, 'attendance'])->name('reports.attendance');
});

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

// Logout route
Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

require __DIR__.'/auth.php';
