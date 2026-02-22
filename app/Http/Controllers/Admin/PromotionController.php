<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promotion;
use App\Models\Product;
use App\Models\Category;

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
        // Map Spanish field names to English
        $data = $request->all();
        $map = [
            'titulo' => 'title',
            'descripcion' => 'description',
            'fecha_inicio' => 'start_date',
            'fecha_fin' => 'end_date',
            'activa' => 'is_active',
            'product_ids' => 'product_ids',
            'categoria_id' => 'category_ids',
        ];
        foreach ($map as $es => $en) {
            if (isset($data[$es])) {
                // Si es categoria_id single, convertir a array
                if ($es === 'categoria_id' && !empty($data[$es]) && $data[$es] !== 'none' && $data[$es] !== '') {
                    $data[$en] = [$data[$es]];
                } else {
                    $data[$en] = $data[$es];
                }
                unset($data[$es]);
            }
        }

        $validated = \Validator::make($data, [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'sometimes|boolean',
        ])->validate();

        $promotion = Promotion::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'discount_percentage' => $validated['discount_percentage'] ?? null,
            'discount_amount' => $validated['discount_amount'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        // Sincronizar productos
        if (!empty($validated['product_ids'])) {
            $promotion->products()->sync($validated['product_ids']);
        }

        // Sincronizar categorías
        if (!empty($validated['category_ids'])) {
            $promotion->categories()->sync($validated['category_ids']);
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
        // Map Spanish field names to English
        $data = $request->all();
        $map = [
            'titulo' => 'title',
            'descripcion' => 'description',
            'fecha_inicio' => 'start_date',
            'fecha_fin' => 'end_date',
            'activa' => 'is_active',
            'product_ids' => 'product_ids',
            'categoria_id' => 'category_ids',
        ];
        foreach ($map as $es => $en) {
            if (isset($data[$es])) {
                // Si es categoria_id single, convertir a array
                if ($es === 'categoria_id' && !empty($data[$es]) && $data[$es] !== 'none' && $data[$es] !== '') {
                    $data[$en] = [$data[$es]];
                } else {
                    $data[$en] = $data[$es];
                }
                unset($data[$es]);
            }
        }

        $validated = \Validator::make($data, [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'sometimes|boolean',
        ])->validate();

        $promotion = Promotion::findOrFail($id);
        $promotion->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'discount_percentage' => $validated['discount_percentage'] ?? null,
            'discount_amount' => $validated['discount_amount'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);

        // Sincronizar productos
        if (isset($validated['product_ids'])) {
            $promotion->products()->sync($validated['product_ids']);
        }

        // Sincronizar categorías
        if (isset($validated['category_ids'])) {
            $promotion->categories()->sync($validated['category_ids']);
        }

        return redirect()->route('admin.promociones.index')->with('success', 'Promoción actualizada correctamente');
    }

    public function destroy(string $id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->delete();

        return redirect()->route('admin.promociones.index')->with('success', 'Promoción eliminada correctamente');
    }

    public function toggle(Request $request, string $id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->is_active = !$promotion->is_active;
        $promotion->save();

        return back()->with('success', 'Estado actualizado');
    }
}
