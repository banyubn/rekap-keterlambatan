<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LateController;
use App\Http\Controllers\RayonController;
use App\Http\Controllers\RombelController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Auth
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login/attempt', [AuthController::class, 'attempt'])->name('login.attempt');    
});

Route::middleware(['auth', 'role:admin'])->prefix('/admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Student
    Route::get('/student', [StudentController::class, 'index'])->name('student.index');
    Route::get('/student/create', [StudentController::class, 'create'])->name('student.create');
    Route::get('/student/edit/{id}', [StudentController::class, 'edit'])->name('student.edit');

    // Rombel
    Route::get('/rombel', [RombelController::class, 'index'])->name('rombel.index');
    Route::get('/rombel/create', [RombelController::class, 'create'])->name('rombel.create');
    Route::get('/rombel/edit/{id}', [RombelController::class, 'edit'])->name('rombel.edit');

    // Rayon
    Route::get('/rayon', [RayonController::class, 'index'])->name('rayon.index');
    Route::get('/rayon/create', [RayonController::class, 'create'])->name('rayon.create');
    Route::get('/rayon/edit/{id}', [RayonController::class, 'edit'])->name('rayon.edit');

    // User
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');

    // Lates
    Route::get('/late', [LateController::class, 'index'])->name('late.index');
    Route::get('/late/recapitulation', [LateController::class, 'recapitulation'])->name('late.recapitulation');
    Route::get('/late/detail/student/{id}', [LateController::class, 'detail'])->name('late.detail');
    Route::get('/late/create', [LateController::class, 'create'])->name('late.create');
    Route::get('/late/edit/{id}', [LateController::class, 'edit'])->name('late.edit');
});

Route::middleware(['auth', 'role:ps'])->prefix('/ps')->name('ps.')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // Student
    Route::get('/student', [StudentController::class, 'index'])->name('student.index');

    // Lates
    Route::get('/late', [LateController::class, 'index'])->name('late.index');
    Route::get('/late/recapitulation', [LateController::class, 'recapitulation'])->name('late.recapitulation');
    Route::get('/late/detail/student/{id}', [LateController::class, 'detail'])->name('late.detail');
});

Route::get('/debug-session', function () {
    return session()->all();
});
