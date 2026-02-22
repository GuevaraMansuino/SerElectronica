<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PromotionController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;

// ============================================================
// 🌐 RUTAS PÚBLICAS (Sin autenticación)
// ============================================================

// Página principal
Route::get('/', function () {
    $categorias = \App\Models\Category::all();
    $productosDestacados = \App\Models\Product::where('destacado', true)->take(8)->get();
    $promociones = \App\Models\Promotion::active()->take(5)->get();
    return view('home', compact('categorias', 'productosDestacados', 'promociones'));
})->name('home');

// Catálogo público
Route::get('/catalogo', function () {
    return view('catalogo.index');
})->name('catalogo.index');

// Ver producto por slug (público)
Route::get('/producto/{slug}', function ($slug) {
    return view('catalogo.show', compact('slug'));
})->name('producto.show');

// Promociones públicas
Route::get('/promociones', function () {
    return view('public.promotions.index');
})->name('promociones.index');

// ============================================================
// 🔓 RUTAS DE AUTENTICACIÓN (API - Sanctum)
// ============================================================

// Login - GET (mostrar formulario)
Route::get('/login', function () {
    if (auth()->check()) {
        return redirect()->route('admin.dashboard');
    }
    return view('auth.login');
})->name('login');

// Login - POST (procesar login)
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Logout - Usa el endpoint API existente
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================================================
// 🔓 RUTAS PÚBLICAS - GET (Lectura sin auth para Admin)
// ============================================================

// Dashboard
Route::get('/admin/dashboard', function () {
    $stats = [
        'productos' => \App\Models\Product::count(),
        'categorias' => \App\Models\Category::count(),
        'promociones' => \App\Models\Promotion::where('is_active', true)->count(),
        'sin_imagen' => \App\Models\Product::whereNull('image')->orWhere('image', '')->count(),
    ];
    
    $ultimosProductos = \App\Models\Product::with('category')->orderBy('created_at', 'desc')->take(5)->get();
    $promocionesActivas = \App\Models\Promotion::where('is_active', true)->orderBy('end_date', 'asc')->take(5)->get();
    
    return view('admin.dashboard', compact('stats', 'ultimosProductos', 'promocionesActivas'));
})->name('admin.dashboard');

// Categorías - Listar
Route::get('/admin/categorias', [CategoryController::class, 'index'])
    ->name('admin.categorias.index');

// Categoría - Ver detalle
Route::get('/admin/categorias/{id}', [CategoryController::class, 'show'])
    ->name('admin.categorias.show');

// Productos - Listar
Route::get('/admin/productos', [ProductController::class, 'index'])
    ->name('admin.productos.index');

// Producto - Ver detalle
Route::get('/admin/productos/{id}', [ProductController::class, 'show'])
    ->name('admin.productos.show');


Route::get('/admin/promociones', [PromotionController::class, 'index'])
    ->name('admin.promociones.index');

// Promoción - Ver detalle
Route::get('/admin/promociones/{id}', [PromotionController::class, 'show'])
    ->name('admin.promociones.show');

// ============================================================
// 🔒 RUTAS PROTEGIDAS - CRUD (Solo admin)
// ============================================================

Route::middleware(['auth:sanctum', 'admin'])->group(function () {

    // ---------- CATEGORÍAS (CRUD) ----------
    // Create - Formulario
    Route::get('/admin/categorias/create', [CategoryController::class, 'create'])
        ->name('admin.categorias.create');
    
    // Create - Guardar
    Route::post('/admin/categorias', [CategoryController::class, 'store'])
        ->name('admin.categorias.store');
    
    // Edit - Formulario
    Route::get('/admin/categorias/{id}/edit', [CategoryController::class, 'edit'])
        ->name('admin.categorias.edit');
    
    // Edit - Actualizar
    Route::put('/admin/categorias/{id}', [CategoryController::class, 'update'])
        ->name('admin.categorias.update');
    
    // Delete
    Route::delete('/admin/categorias/{id}', [CategoryController::class, 'destroy'])
        ->name('admin.categorias.destroy');

    // ---------- PRODUCTOS (CRUD) ----------
    // Listar
    Route::get('/admin/productos', [AdminProductController::class, 'index'])
        ->name('admin.productos.index');
    
    // Create - Formulario
    Route::get('/admin/productos/create', [AdminProductController::class, 'create'])
        ->name('admin.productos.create');
    
    // Create - Guardar
    Route::post('/admin/productos', [AdminProductController::class, 'store'])
        ->name('admin.productos.store');
    
    // Edit - Formulario
    Route::get('/admin/productos/{id}/edit', [AdminProductController::class, 'edit'])
        ->name('admin.productos.edit');
    
    // Edit - Actualizar
    Route::put('/admin/productos/{id}', [AdminProductController::class, 'update'])
        ->name('admin.productos.update');
    
    // Delete
    Route::delete('/admin/productos/{id}', [AdminProductController::class, 'destroy'])
        ->name('admin.productos.destroy');
    
    // Toggle activo
    Route::patch('/admin/productos/{id}/toggle', [AdminProductController::class, 'toggle'])
        ->name('admin.productos.toggle');

    // ---------- PROMOCIONES (CRUD) ----------
    // Create - Formulario
    Route::get('/admin/promociones/create', [PromotionController::class, 'create'])
        ->name('admin.promociones.create');
    
    // Create - Guardar
    Route::post('/admin/promociones', [PromotionController::class, 'store'])
        ->name('admin.promociones.store');
    
    // Edit - Formulario
    Route::get('/admin/promociones/{id}/edit', [PromotionController::class, 'edit'])
        ->name('admin.promociones.edit');
    
    // Edit - Actualizar
    Route::put('/admin/promociones/{id}', [PromotionController::class, 'update'])
        ->name('admin.promociones.update');
    
    // Delete
    Route::delete('/admin/promociones/{id}', [PromotionController::class, 'destroy'])
        ->name('admin.promociones.destroy');

    // ---------- IMPORTACIÓN ----------
    Route::post('/import/products', [\App\Http\Controllers\Api\ImportController::class, 'importProducts'])
        ->name('import.products');
    
    Route::post('/import/categories', [\App\Http\Controllers\Api\ImportController::class, 'importCategories'])
        ->name('import.categories');
});
