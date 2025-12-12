<?php

use App\Http\Controllers\OutletManagementController;
use App\Http\Controllers\UserManagementController;
use App\Models\Outlet;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\Welcome;

Route::redirect('/', '/login');
// Route::get('/', Welcome::class);
// Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Route::resource('users', UserManagementController::class);
// Admin Route
// TODO: implement middleware
Route::prefix('admin')->name('admin')->group(function () {
    Route::resource('users', UserManagementController::class);
});

// Owner Route
Route::prefix('owner')->name('owner.')->group(function () {
    // Route::resource('outlets', OutletManagementController::class)->only([
    //     'index',
    //     'store',
    //     'update',
    //     'show',
    //     'destroy'
    // ]);
});

require __DIR__ . '/auth.php';
