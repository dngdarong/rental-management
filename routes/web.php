<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminTenantController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\RoomTypeController; // Import RoomTypeController
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Redirect root to login page for unauthenticated users
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }
    return view('auth.login');
})->name('home');

// Admin Panel Routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Room Management
    Route::resource('rooms', RoomController::class);

    // Room Type Management - ENSURE THIS LINE IS UNCOMMENTED
    Route::resource('room-types', RoomTypeController::class);

    // Admin Tenant Management (accessible only by Super Admin via Gate)
    Route::resource('admin-tenants', AdminTenantController::class);

    // Placeholder for other admin resource routes:
    // Route::resource('tenants', TenantController::class);
    // Route::resource('rents', RentController::class);
    // Route::resource('payments', PaymentController::class);
    // Route::resource('maintenance-requests', MaintenanceRequestController::class);

    // Admin Profile/Settings (using the existing Breeze ProfileController)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

