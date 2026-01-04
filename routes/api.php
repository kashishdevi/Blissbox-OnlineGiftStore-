<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProductAPIController;
use App\Http\Controllers\API\CategoryAPIController;
use App\Http\Controllers\API\OrderAPIController;
use App\Http\Controllers\API\AuthAPIController;
use App\Http\Controllers\API\AdminAPIController;

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
    
    // Authentication - Public
    Route::post('/register', [AuthAPIController::class, 'register']);
    Route::post('/login', [AuthAPIController::class, 'login']);
    Route::post('/admin/register', [AuthAPIController::class, 'adminRegister']);
    Route::post('/admin/login', [AuthAPIController::class, 'adminLogin']);
});

// Protected API Routes (Require Authentication)
Route::middleware('api.auth')->prefix('v1')->group(function () {
    // User info
    Route::get('/user', [AuthAPIController::class, 'user']);
    
    // Logout
    Route::post('/logout', [AuthAPIController::class, 'logout']);
    
    // Orders CRUD (Authenticated users)
    Route::get('/orders', [OrderAPIController::class, 'index']);
    Route::get('/orders/{id}', [OrderAPIController::class, 'show']);
    Route::post('/orders', [OrderAPIController::class, 'store']);
    Route::put('/orders/{id}', [OrderAPIController::class, 'update']);
});

// Admin Protected Routes (Require Admin Authentication)
Route::middleware(['api.auth', 'admin'])->prefix('v1/admin')->group(function () {
    // Admin Products CRUD
    Route::get('/products', [AdminAPIController::class, 'getAllProducts']);
    Route::get('/products/{id}', [AdminAPIController::class, 'getProduct']);
    Route::post('/products', [AdminAPIController::class, 'createProduct']);
    Route::put('/products/{id}', [AdminAPIController::class, 'updateProduct']);
    Route::delete('/products/{id}', [AdminAPIController::class, 'deleteProduct']);
    
    // Admin Categories CRUD
    Route::get('/categories', [AdminAPIController::class, 'getAllCategories']);
    Route::post('/categories', [CategoryAPIController::class, 'store']);
    Route::put('/categories/{id}', [CategoryAPIController::class, 'update']);
    Route::delete('/categories/{id}', [CategoryAPIController::class, 'destroy']);
    
    // Admin Orders
    Route::get('/orders', [AdminAPIController::class, 'getAllOrders']);
    Route::get('/orders/{id}', [OrderAPIController::class, 'show']);
    Route::put('/orders/{id}', [OrderAPIController::class, 'update']);
    Route::delete('/orders/{id}', [OrderAPIController::class, 'destroy']);
});
