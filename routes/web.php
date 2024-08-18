<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\RewardController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('', [AuthenticationController::class, 'login'])->name('login');
    Route::post('', [AuthenticationController::class, 'cekLogin'])->name('cek-login');

    Route::get('register', [AuthenticationController::class, 'register'])->name('register');
    Route::post('register', [AuthenticationController::class, 'cekRegister'])->name('cek-register');
});


Route::middleware('auth')->group(function () {
    Route::prefix('reward')->group(function () {
        Route::get('', [RewardController::class, 'index'])->name('reward');
        Route::get('sd', [RewardController::class, 'index'])->name('cashflow.update');
    });

    Route::get('logout', [AuthenticationController::class, 'logout'])->name('logout');
});

