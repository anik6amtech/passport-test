<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public authentication routes
Route::prefix('auth')->group(function () {
    // Login endpoint with user type parameter
    Route::post('login/{userType}', [AuthController::class, 'login'])
         ->where('userType', 'admin|customer|deliveryman|supplier');
});

// Protected routes for all user types
Route::middleware('auth:api')->prefix('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
});

// Protected routes for specific user types
Route::middleware(['auth:api', 'check.user.type:admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', function (Request $request) {
        return response()->json([
            'success' => true,
            'message' => 'Admin dashboard accessed successfully',
            'user' => $request->user()
        ]);
    });
});

Route::middleware(['auth:api', 'check.user.type:customer'])->prefix('customer')->group(function () {
    Route::get('dashboard', function (Request $request) {
        return response()->json([
            'success' => true,
            'message' => 'Customer dashboard accessed successfully',
            'user' => $request->user()
        ]);
    });
});

Route::middleware(['auth:api', 'check.user.type:deliveryman'])->prefix('deliveryman')->group(function () {
    Route::get('dashboard', function (Request $request) {
        return response()->json([
            'success' => true,
            'message' => 'Deliveryman dashboard accessed successfully',
            'user' => $request->user()
        ]);
    });
});

Route::middleware(['auth:api', 'check.user.type:supplier'])->prefix('supplier')->group(function () {
    Route::get('dashboard', function (Request $request) {
        return response()->json([
            'success' => true,
            'message' => 'Supplier dashboard accessed successfully',
            'user' => $request->user()
        ]);
    });
});