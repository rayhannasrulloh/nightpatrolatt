<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest:employee'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    })->name('login');
    Route::post('/login_process', [AuthController::class, 'login_process']);
});

Route::middleware(['auth:employee'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/logout_process', [AuthController::class, 'logout_process']);

    Route::get('/attendance/create',[AttendanceController::class, 'create']);
    Route::post('/attendance/store',[AttendanceController::class, 'store']);
});