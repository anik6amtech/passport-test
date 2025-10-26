<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login/admin', [LoginController::class, 'loginAdmin'])->name('login.admin');
Route::post('/login/customer', [LoginController::class, 'loginCustomer'])->name('login.customer');
Route::post('/login/deliveryman', [LoginController::class, 'loginDeliveryman'])->name('login.deliveryman');
Route::post('/login/supplier', [LoginController::class, 'loginSupplier'])->name('login.supplier');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Dashboard Routes (placeholder routes for demonstration)
Route::get('/admin/dashboard', function () {
    return view('dashboards.admin');
})->name('admin.dashboard');

Route::get('/customer/dashboard', function () {
    return view('dashboards.customer');
})->name('customer.dashboard');

Route::get('/deliveryman/dashboard', function () {
    return view('dashboards.deliveryman');
})->name('deliveryman.dashboard');

Route::get('/supplier/dashboard', function () {
    return view('dashboards.supplier');
})->name('supplier.dashboard');
