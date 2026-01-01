<?php

use App\Http\Controllers\OutletController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffManagementController;
use App\Http\Controllers\LaundryServiceController;
use App\Http\Controllers\Staff\StaffOrderController;
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

// NOTE: yes, for now admin is useless, but dont worry it wont be for long
// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::resource('staff', StaffManagementController::class);
//     Route::resource('outlet.services', LaundryServiceController::class);
//     Route::resource('outlet', OutletController::class);
// });

Route::middleware(['auth', 'role:owner', 'owner'])->group(function () {
    Route::resource('outlet', OutletController::class);
    Route::resource('outlet.services', LaundryServiceController::class);
    Route::resource('outlet.staff', StaffManagementController::class);
    Route::resource('outlet.staff.order', StaffOrderController::class);
});

Route::middleware(['auth', 'role:staff', 'staff'])->group(function () {
    Route::get('staff/orders', [StaffOrderController::class, 'index'])->name('staff.orders.index');
    Route::get('staff/orders/create', [StaffOrderController::class, 'create'])->name('staff.orders.create');
    Route::post('staff/orders', [StaffOrderController::class, 'store'])->name('staff.orders.store');
    Route::get('staff/orders/{order}', [StaffOrderController::class, 'show'])->name('staff.orders.show');
    Route::patch('staff/orders/{order}', [StaffOrderController::class, 'update'])->name('staff.orders.update');
});

require __DIR__ . '/auth.php';
