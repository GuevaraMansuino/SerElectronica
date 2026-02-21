<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PromotionController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ImportController;

/*
|--------------------------------------------------------------------------
| 🔓 RUTAS PÚBLICAS (Sin autenticación)
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::prefix('public')->group(function () {
    // Categorías
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{id}', [CategoryController::class, 'show']);
    Route::get('/categories/slug/{slug}', [CategoryController::class, 'showBySlug']);

    // Productos
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::get('/products/slug/{slug}', [ProductController::class, 'showBySlug']);
    // Scroll infinito - cargar más productos
    Route::get('/products/load-more', [ProductController::class, 'loadMore']);

    // Promociones
    Route::get('/promotions', [PromotionController::class, 'index']);
    Route::get('/promotions/{id}', [PromotionController::class, 'show']);
    Route::get('/promotions/featured', [PromotionController::class, 'featured']);
});

/*
|--------------------------------------------------------------------------
| 🔒 RUTAS PROTEGIDAS (Requiere token de admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'admin'])->group(function () {

    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    // Importación
    Route::post('/import/products', [ImportController::class, 'importProducts']);
    Route::post('/import/categories', [ImportController::class, 'importCategories']);

    // Categorías (CRUD completo)
    Route::apiResource('admin/categories', CategoryController::class);

    // Productos (CRUD completo)
    Route::apiResource('admin/products', ProductController::class);

    // Promociones (CRUD completo)
    Route::apiResource('admin/promotions', PromotionController::class);
});
