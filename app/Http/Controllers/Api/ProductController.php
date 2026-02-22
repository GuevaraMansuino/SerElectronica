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
        $product = Product::withRelations()->where('slug', $slug)->firstOrFail();
        return response()->json($product);
    }

    /**
     * Cargar más productos para scroll infinito
     */
    public function loadMore(Request $request)
    {
        $page = $request->get('page', 2); // Por defecto empezar desde página 2
        $categoria = $request->get('categoria');
        $perPage = 12;

        $query = Product::with('category')->with('promotions')->where('is_active', true);

        // Filtrar por categoría si se especifica
        if ($categoria) {
            $query->whereHas('category', function($q) use ($categoria) {
                $q->where('slug', $categoria);
            });
        }

        $productos = $query->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

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
