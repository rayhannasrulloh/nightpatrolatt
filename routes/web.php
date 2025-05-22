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

    Route::get('/editprofile',[AttendanceController::class, 'editprofile']);
    Route::post('/attendance/{employee_id}/updateprofile',[AttendanceController::class, 'updateprofile']);

    Route::get('/attendance/history',[AttendanceController::class, 'history']);
    Route::post('/gethistory',[AttendanceController::class, 'gethistory']);

    Route::get('/attendance/permit',[AttendanceController::class, 'permit']);
    Route::get('/attendance/createpermit',[AttendanceController::class, 'createpermit']);
    
});