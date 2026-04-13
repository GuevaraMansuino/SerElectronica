<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PromotionController extends Controller
{
    public function index()
    {
        $promociones = Promotion::with(['products', 'categories'])->latest()->paginate(15);
        return view('admin.promociones.index', compact('promociones'));
    }

    public function create()
    {
        $productos = Product::where('is_active', true)->get();
        $categorias = Category::all();
        return view('admin.promociones.create', compact('productos', 'categorias'));
    }

    public function store(\App\Http\Requests\StorePromotionRequest $request)
    {
        // Los campos ya están mapeados en el Request
        $validated = $request->validated();

        $startDate = !empty($validated['start_date']) ? $validated['start_date'] : null;
        $endDate = !empty($validated['end_date']) ? $validated['end_date'] : null;

        $promotion = Promotion::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'discount_percentage' => $validated['discount_percentage'] ?? null,
            'discount_amount' => $validated['discount_amount'] ?? null,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        // Sincronizar productos solo si product_scope es 'specific' y hay productos seleccionados
        $productScope = $request->input('product_scope', 'none');
        if ($productScope === 'specific' && !empty($validated['product_ids'])) {
            $promotion->products()->sync($validated['product_ids']);
        } elseif ($productScope === 'all') {
            // Si es "Todos los productos", sincronizamos a todos los productos activos
            $allProductIds = Product::where('is_active', true)->pluck('id')->toArray();
            $promotion->products()->sync($allProductIds);
        } else {
            // Si no es specific ni all, limpiar cualquier asociación existente
            $promotion->products()->sync([]);
        }

        // Sincronizar categorías solo si hay una categoría válida seleccionada
        $categoriaId = $request->input('categoria_id', 'none');
        if (!empty($validated['category_ids']) && $validated['category_ids'][0] !== '' && $validated['category_ids'][0] !== 'none') {
            $promotion->categories()->sync($validated['category_ids']);
        } elseif ($categoriaId === '') {
            // "Todas las categorias" seleccionado (value="")
            $allCategoryIds = Category::pluck('id')->toArray();
            $promotion->categories()->sync($allCategoryIds);
        } else {
            $promotion->categories()->sync([]);
        }

        return redirect()->route('admin.promociones.index')->with('success', 'Promoción creada correctamente');
    }

    public function edit(string $id)
    {
        $promocion = Promotion::with(['products', 'categories'])->findOrFail($id);
        $productos = Product::where('is_active', true)->get();
        $categorias = Category::all();
        return view('admin.promociones.edit', compact('promocion', 'productos', 'categorias'));
    }

    public function update(\App\Http\Requests\UpdatePromotionRequest $request, string $id)
    {
        // Los campos ya están mapeados en el Request
        $validated = $request->validated();

        $promotion = Promotion::findOrFail($id);
        
        $startDate = !empty($validated['start_date']) ? $validated['start_date'] : null;
        $endDate = !empty($validated['end_date']) ? $validated['end_date'] : null;
        
        $promotion->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'discount_percentage' => $validated['discount_percentage'] ?? null,
            'discount_amount' => $validated['discount_amount'] ?? null,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        // Sincronizar productos solo si product_scope es 'specific' y hay productos seleccionados
        $productScope = $request->input('product_scope', 'none');
        if ($productScope === 'specific' && !empty($validated['product_ids'])) {
            $promotion->products()->sync($validated['product_ids']);
        } elseif ($productScope === 'all') {
            // Si es "Todos los productos", sincronizamos a todos los productos activos
            $allProductIds = Product::where('is_active', true)->pluck('id')->toArray();
            $promotion->products()->sync($allProductIds);
        } else {
            // Si no es specific ni all, limpiar cualquier asociación existente
            $promotion->products()->sync([]);
        }

        // Sincronizar categorías solo si hay una categoría válida seleccionada
        $categoriaId = $request->input('categoria_id', 'none');
        if (!empty($validated['category_ids']) && $validated['category_ids'][0] !== '' && $validated['category_ids'][0] !== 'none') {
            $promotion->categories()->sync($validated['category_ids']);
        } elseif ($categoriaId === '') {
            // "Todas las categorias" seleccionado (value="")
            $allCategoryIds = Category::pluck('id')->toArray();
            $promotion->categories()->sync($allCategoryIds);
        } else {
            $promotion->categories()->sync([]);
        }

        return redirect()->route('admin.promociones.index')->with('success', 'Promoción actualizada correctamente');
    }

    public function destroy(string $id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->delete();

        return back()->with('success', 'Promoción eliminada correctamente');
    }

    public function toggle(Request $request, string $id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->is_active = !$promotion->is_active;
        $promotion->save();

        return back()->with('success', 'Estado actualizado');
    }

    public function togglePost(Request $request, string $id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->is_active = !$promotion->is_active;
        $promotion->save();

        return back()->with('success', 'Estado actualizado');
    }
}
