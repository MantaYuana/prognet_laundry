<?php

use App\Http\Controllers\OutletController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffManagementController;
use App\Http\Controllers\LaundryServiceController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
// Route::redirect('/', '/login');

Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('staff', StaffManagementController::class);
    Route::resource('outlet.services', LaundryServiceController::class);
    Route::resource('outlet', OutletController::class);
});

Route::middleware(['auth', 'role:owner', 'owner'])->group(function () {
    Route::resource('outlet', OutletController::class);
    Route::resource('outlet.services', LaundryServiceController::class);
    Route::resource('staff', StaffManagementController::class);
});

require __DIR__ . '/auth.php';
