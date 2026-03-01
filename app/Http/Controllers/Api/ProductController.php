<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Traits\ImageTrait;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    use ImageTrait;

    public function index()
    {
        return Product::withRelations()->get();
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();

        // Guardar imagen
        $validated['image'] = $this->saveImage($request, 'image');

        $product = Product::create($validated);

        return response()->json($product->load('category', 'promotions'), 201);
    }

    public function show(string $id)
    {
        return Product::withRelations()->findOrFail($id);
    }

    public function edit(string $id)
    {
        $producto = Product::withRelations()->findOrFail($id);
        $categorias = \App\Models\Category::all();
        return view('admin.productos.edit', compact('producto', 'categorias'));
    }

    public function showBySlug(string $slug)
    {
        $product = Product::withRelations()->where('is_active', true)->where('slug', $slug)->firstOrFail();
        return response()->json($product);
    }

    /**
     * Cargar más productos para scroll infinito
     */
    public function loadMore(Request $request)
    {
        $page = $request->get('page', 2); // Por defecto empezar desde página 2
        $categoria = $request->get('categoria');
        $busqueda = $request->get('q');
        $precioMin = $request->get('precio_min');
        $precioMax = $request->get('precio_max');
        $orden = $request->get('orden', 'reciente');
        $perPage = 12;

        $query = Product::with(['category', 'promotions', 'category.promotions'])->where('is_active', true);

        // Filtrar por categoría si se especifica
        if ($categoria) {
            $query->whereHas('category', function($q) use ($categoria) {
                $q->where('slug', $categoria);
            });
        }

        // Aplicar búsqueda parcial
        if ($busqueda) {
            $query->search($busqueda);
        }

        // Aplicar filtro de precio mínimo (considerando precio con promoción)
        if ($precioMin !== null && $precioMin !== '') {
            $query->where(function($q) use ($precioMin) {
                $q->where('price', '>=', (float) $precioMin)
                  ->orWhereHas('promotions', function($promoQuery) use ($precioMin) {
                      $promoQuery->where('is_active', true)
                          ->where(function($pq) use ($precioMin) {
                              $pq->whereRaw(
                                  "CASE 
                                      WHEN discount_percentage IS NOT NULL THEN price - (price * discount_percentage / 100) - COALESCE(discount_amount, 0)
                                      WHEN discount_amount IS NOT NULL THEN price - discount_amount
                                      ELSE price
                                  END >= ?",
                                  [(float) $precioMin]
                              );
                          });
                  })
                  ->orWhereHas('category.promotions', function($promoQuery) use ($precioMin) {
                      $promoQuery->where('is_active', true)
                          ->where(function($pq) use ($precioMin) {
                              $pq->whereRaw(
                                  "CASE 
                                      WHEN discount_percentage IS NOT NULL THEN price - (price * discount_percentage / 100) - COALESCE(discount_amount, 0)
                                      WHEN discount_amount IS NOT NULL THEN price - discount_amount
                                      ELSE price
                                  END >= ?",
                                  [(float) $precioMin]
                              );
                          });
                  });
            });
        }

        // Aplicar filtro de precio máximo
        if ($precioMax !== null && $precioMax !== '') {
            $query->where(function($q) use ($precioMax) {
                $q->where('price', '<=', (float) $precioMax)
                  ->orWhereHas('promotions', function($promoQuery) use ($precioMax) {
                      $promoQuery->where('is_active', true)
                          ->where(function($pq) use ($precioMax) {
                              $pq->whereRaw(
                                  "CASE 
                                      WHEN discount_percentage IS NOT NULL THEN price - (price * discount_percentage / 100) - COALESCE(discount_amount, 0)
                                      WHEN discount_amount IS NOT NULL THEN price - discount_amount
                                      ELSE price
                                  END <= ?",
                                  [(float) $precioMax]
                              );
                          });
                  })
                  ->orWhereHas('category.promotions', function($promoQuery) use ($precioMax) {
                      $promoQuery->where('is_active', true)
                          ->where(function($pq) use ($precioMax) {
                              $pq->whereRaw(
                                  "CASE 
                                      WHEN discount_percentage IS NOT NULL THEN price - (price * discount_percentage / 100) - COALESCE(discount_amount, 0)
                                      WHEN discount_amount IS NOT NULL THEN price - discount_amount
                                      ELSE price
                                  END <= ?",
                                  [(float) $precioMax]
                              );
                          });
                  });
            });
        }

        // Aplicar ordenamiento
        switch ($orden) {
            case 'precio_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'precio_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'nombre':
                $query->orderBy('name', 'asc');
                break;
            case 'reciente':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $productos = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'products' => $productos->items(),
            'current_page' => $productos->currentPage(),
            'last_page' => $productos->lastPage(),
            'has_more' => $productos->hasMorePages()
        ]);
    }

    public function update(UpdateProductRequest $request, string $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validated();

        // Si hay nueva imagen, eliminar la anterior
        if ($request->hasFile('image')) {
            $this->deleteImage($product->image);
            $validated['image'] = $this->saveImage($request, 'image');
        } elseif ($request->has('image') && $request->image !== $product->image) {
            // Si explicitamente se envía una nueva imagen (por URL o nombre)
            $this->deleteImage($product->image);
            $validated['image'] = $request->image;
        }

        $product->update($validated);

        return response()->json($product->load('category', 'promotions'));
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        
        // Eliminar imagen
        $this->deleteImage($product->image);
        
        $product->delete();

        return response()->json(['message' => 'Product deleted']);
    }
}
