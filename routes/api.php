<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductAPIController;
use App\Http\Controllers\API\CategoryAPIController;
use App\Http\Controllers\API\OrderAPIController;
use App\Http\Controllers\API\AuthAPIController;

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

// Public API Routes (No authentication required)
Route::prefix('v1')->group(function () {
    // Products - Public (read-only)
    Route::get('/products', [ProductAPIController::class, 'index']);
    Route::get('/products/{id}', [ProductAPIController::class, 'show']);
    Route::get('/products/search', [ProductAPIController::class, 'search']);
    
    // Categories - Public (read-only)
    Route::get('/categories', [CategoryAPIController::class, 'index']);
    Route::get('/categories/{id}', [CategoryAPIController::class, 'show']);
    
    // Authentication
    Route::post('/register', [AuthAPIController::class, 'register']);
    Route::post('/login', [AuthAPIController::class, 'login']);
});

// Protected API Routes (Require Passport Authentication)
Route::middleware('auth:api')->prefix('v1')->group(function () {
    // User info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Products CRUD (Admin only)
    Route::middleware('admin')->group(function () {
        Route::post('/products', [ProductAPIController::class, 'store']);
        Route::put('/products/{id}', [ProductAPIController::class, 'update']);
        Route::delete('/products/{id}', [ProductAPIController::class, 'destroy']);
    });
    
    // Categories CRUD (Admin only)
    Route::middleware('admin')->group(function () {
        Route::post('/categories', [CategoryAPIController::class, 'store']);
        Route::put('/categories/{id}', [CategoryAPIController::class, 'update']);
        Route::delete('/categories/{id}', [CategoryAPIController::class, 'destroy']);
    });
    
    // Orders CRUD
    Route::get('/orders', [OrderAPIController::class, 'index']);
    Route::get('/orders/{id}', [OrderAPIController::class, 'show']);
    Route::post('/orders', [OrderAPIController::class, 'store']);
    Route::put('/orders/{id}', [OrderAPIController::class, 'update']);
    
    // Logout
    Route::post('/logout', [AuthAPIController::class, 'logout']);
});

