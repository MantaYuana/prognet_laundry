<?php

use App\Http\Controllers\OutletController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffManagementController;
use App\Http\Controllers\LaundryServiceController;
use App\Http\Controllers\Staff\StaffOrderController;
use App\Http\Controllers\Customer\CustomerOrderController;
use App\Http\Controllers\Customer\CustomerOutletFinderController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
// Route::redirect('/', '/login');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// NOTE: yes, for now admin is useless, but dont worry it wont be for long
// NOTE: okay maybe this shit is useless, fck it we balls deep alr
// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::resource('staff', StaffManagementController::class);
//     Route::resource('outlet.services', LaundryServiceController::class);
//     Route::resource('outlet', OutletController::class);
// });

// TODO: also try to refactor views name bcuz it shit ass

// NOTE: fuck this stupid wildcard conflict shit, worked on this shit for 3 hour fucker fucking shit
// TODO: add middleware for ensure customer
Route::middleware(['auth', 'role:customer'])->group(function () {
// Route::middleware(['auth', 'role:customer', 'customer'])->group(function () {
    Route::get('outlet/find', [CustomerOutletFinderController::class, 'index'])->name('customer.outlet.index');
    Route::get('outlet/find/{outlet}', [CustomerOutletFinderController::class, 'show'])->name('customer.outlet.show');
    Route::get('orders', [CustomerOrderController::class, 'index'])->name('customer.order.index');
    Route::get('orders/{order}', [CustomerOrderController::class, 'show'])->name('customer.order.show');
});

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
