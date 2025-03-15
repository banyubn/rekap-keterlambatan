<?php

use App\Http\Controllers\Api\LateController;
use App\Http\Controllers\Api\RayonController;
use App\Http\Controllers\Api\RombelController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/test', function () {
    return response()->json(['message' => 'test']);
});

// Route::ApiResource('/student', StudentController::class);

Route::name('api.')->group(function () {
    // Student
    Route::get('/student', [StudentController::class, 'all'])->name('student.all');
    Route::get('/student/table', [StudentController::class, 'table'])->name('student.table');
    Route::get('/student/{id}', [StudentController::class, 'show'])->name('student.show');
    Route::put('/student/{id}', [StudentController::class, 'update'])->name('student.update');
    Route::post('/student', [StudentController::class, 'store'])->name('student.store');
    Route::delete('/student/{id}', [StudentController::class, 'destroy'])->name('student.destroy');

    // Rombel
    Route::get('/rombel', [RombelController::class, 'all'])->name('rombel.all');
    Route::get('/rombel/table', [RombelController::class, 'table'])->name('rombel.table');
    Route::get('/rombel/{id}', [RombelController::class, 'show'])->name('rombel.show');
    Route::put('/rombel/{id}', [RombelController::class, 'update'])->name('rombel.update');
    Route::post('/rombel', [RombelController::class, 'store'])->name('rombel.store');
    Route::delete('/rombel/{id}', [RombelController::class, 'destroy'])->name('rombel.destroy');

    // Rayon
    Route::get('/rayon', [RayonController::class, 'all'])->name('rayon.all');
    Route::get('/rayon/table', [RayonController::class, 'table'])->name('rayon.table');
    Route::get('/rayon/{id}', [RayonController::class, 'show'])->name('rayon.show');
    Route::put('/rayon/{id}', [RayonController::class, 'update'])->name('rayon.update');
    Route::post('/rayon', [RayonController::class, 'store'])->name('rayon.store');
    Route::delete('/rayon/{id}', [RayonController::class, 'destroy'])->name('rayon.destroy');

    // User
    Route::get('/user', [UserController::class, 'all'])->name('user.all');
    Route::get('/user/table', [UserController::class, 'table'])->name('user.table');
    Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
    Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::post('/user', [UserController::class, 'store'])->name('user.store');
    Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    // Lates
    Route::get('/late', [LateController::class, 'all'])->name('late.all');
    Route::get('/late/table', [LateController::class, 'table'])->name('late.table');
    Route::get('/late/detail/student/{id}', [LateController::class, 'detail'])->name('late.detail');
    Route::put('/late/{id}', [LateController::class, 'update'])->name('late.update');
    Route::post('/late', [LateController::class, 'store'])->name('late.store');
    Route::delete('/late/{id}', [LateController::class, 'destroy'])->name('late.destroy');
});