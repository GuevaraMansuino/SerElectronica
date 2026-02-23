<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PromotionController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\PromotionController as AdminPromotionController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

// ============================================================
// 🌐 RUTAS PÚBLICAS (Sin autenticación)
// ============================================================

// Página principal
Route::get('/', function () {
    $categorias = \App\Models\Category::all();
    $productosDestacados = \App\Models\Product::where('is_active', true)->where('destacado', true)->take(8)->get();
    $promociones = \App\Models\Promotion::active()->take(5)->get();
    return view('home', compact('categorias', 'productosDestacados', 'promociones'));
})->name('home');

// Catálogo público
Route::get('/catalogo', function () {
    $categorias = \App\Models\Category::withCount('productos')->get();
    $totalProductos = \App\Models\Product::where('is_active', true)->count();
    $productos = \App\Models\Product::with('category')->where('is_active', true)->paginate(12);
    return view('catalogo.index', compact('categorias', 'totalProductos', 'productos'));
})->name('catalogo.index');

// Ver producto por slug (público)
Route::get('/producto/{slug}', function ($slug) {
    $producto = \App\Models\Product::with('category', 'promotions', 'images')->where('is_active', true)->where('slug', $slug)->firstOrFail();
    $relacionados = \App\Models\Product::where('is_active', true)->where('category_id', $producto->category_id)->where('id', '!=', $producto->id)->take(4)->get();
    return view('catalogo.show', compact('producto', 'relacionados'));
})->name('producto.show');

// Promociones públicas
Route::get('/promociones', function () {
    $promociones = \App\Models\Promotion::where('is_active', true)
        ->where(function($query) {
            $query->whereDate('start_date', '<=', now())
                  ->orWhereNull('start_date');
        })
        ->where(function($query) {
            $query->whereDate('end_date', '>=', now())
                  ->orWhereNull('end_date');
        })
        ->orderBy('created_at', 'desc')
        ->get();

    // Productos que tienen promociones activas
    $productosEnPromo = \App\Models\Product::where('is_active', true)
        ->whereHas('promotions', function($query) {
            $query->where('is_active', true)
                ->where(function($q) {
                    $q->whereDate('start_date', '<=', now())
                      ->orWhereNull('start_date');
                })
                ->where(function($q) {
                    $q->whereDate('end_date', '>=', now())
                      ->orWhereNull('end_date');
                });
        })
        ->with('category', 'promotions', 'images')
        ->get();

    return view('public.promotions.index', compact('promociones', 'productosEnPromo'));
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
Route::get('/admin/categorias', [AdminCategoryController::class, 'index'])
    ->name('admin.categorias.index');

// Categoría - Ver detalle
Route::get('/admin/categorias/{id}', [AdminCategoryController::class, 'show'])
    ->name('admin.categorias.show')
    ->where('id', '[0-9]+');

// Productos - Listar
Route::get('/admin/productos', [ProductController::class, 'index'])
    ->name('admin.productos.index');

// Producto - Ver detalle
Route::get('/admin/productos/{id}', [ProductController::class, 'show'])
    ->name('admin.productos.show')
    ->where('id', '[0-9]+');


Route::get('/admin/promociones', [AdminPromotionController::class, 'index'])
    ->name('admin.promociones.index');

// ============================================================
// 🔒 RUTAS PROTEGIDAS - CRUD (Solo admin)
// ============================================================

Route::middleware(['auth:sanctum', 'admin'])->group(function () {

    // ---------- PROMICIONES (CRUD) ----------
    // Create - Formulario
    Route::get('/admin/promociones/create', [AdminPromotionController::class, 'create'])
        ->name('admin.promociones.create');

    // Create - Guardar
    Route::post('/admin/promociones', [AdminPromotionController::class, 'store'])
        ->name('admin.promociones.store');

    // Edit - Formulario
    Route::get('/admin/promociones/{id}/edit', [AdminPromotionController::class, 'edit'])
        ->name('admin.promociones.edit');

    // Edit - Actualizar
    Route::put('/admin/promociones/{id}', [AdminPromotionController::class, 'update'])
        ->name('admin.promociones.update');

    // Delete
    Route::delete('/admin/promociones/{id}', [AdminPromotionController::class, 'destroy'])
        ->name('admin.promociones.destroy');

    // Toggle active/inactive - using signed URL for reliability
    Route::get('/admin/promociones/{id}/toggle', [AdminPromotionController::class, 'toggle'])
        ->name('admin.promociones.toggle')
        ->middleware('signed');
    
    // Also support POST/PATCH for backwards compatibility with cached forms
    Route::post('/admin/promociones/{id}/toggle', [AdminPromotionController::class, 'togglePost'])
        ->name('admin.promociones.toggle.post');
    
    Route::patch('/admin/promociones/{id}/toggle', [AdminPromotionController::class, 'togglePost'])
        ->name('admin.promociones.toggle.patch');

    // ---------- CATEGORÍAS (CRUD) ----------
    // Create - Formulario
    Route::get('/admin/categorias/create', [AdminCategoryController::class, 'create'])
        ->name('admin.categorias.create');
    
    // Create - Guardar
    Route::post('/admin/categorias', [AdminCategoryController::class, 'store'])
        ->name('admin.categorias.store');
    
    // Edit - Formulario
    Route::get('/admin/categorias/{id}/edit', [AdminCategoryController::class, 'edit'])
        ->name('admin.categorias.edit');
    
    // Edit - Actualizar
    Route::put('/admin/categorias/{id}', [AdminCategoryController::class, 'update'])
        ->name('admin.categorias.update');
    
    // Delete
    Route::delete('/admin/categorias/{id}', [AdminCategoryController::class, 'destroy'])
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

    // ---------- IMPORTACIÓN ----------
    Route::post('/import/products', [\App\Http\Controllers\Api\ImportController::class, 'importProducts'])
        ->name('import.products');
    
    Route::post('/import/categories', [\App\Http\Controllers\Api\ImportController::class, 'importCategories'])
        ->name('import.categories');
});
