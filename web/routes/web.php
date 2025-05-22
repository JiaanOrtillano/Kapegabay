<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Farmer Authentication Routes
Route::get('farmer/login', [App\Http\Controllers\Auth\FarmerLoginController::class, 'showLoginForm'])->name('farmer.login');
Route::post('farmer/login', [App\Http\Controllers\Auth\FarmerLoginController::class, 'login']);
Route::post('farmer/logout', [App\Http\Controllers\Auth\FarmerLoginController::class, 'logout'])->name('farmer.logout');

// Protected Farmer Routes
Route::middleware(['auth:farmer'])->group(function () {
    Route::get('/farmer/dashboard', function () {
        return view('dashboard');
    })->name('farmer.dashboard');
});

require __DIR__.'/auth.php';
