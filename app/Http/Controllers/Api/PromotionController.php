<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePromotionRequest;
use App\Http\Requests\UpdatePromotionRequest;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    /**
     * Mostrar promociones activas (público)
     */
    public function index()
    {
        $promotions = Promotion::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('start_date')
                      ->orWhereDate('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                      ->orWhereDate('end_date', '>=', now());
            })
            ->get();

        return response()->json($promotions);
    }

    /**
     * Mostrar una promoción específica (público)
     */
    public function show(Promotion $promotion)
    {
        return response()->json($promotion);
    }

    public function featured()
    {
        $promotions = Promotion::active()
            ->with(['products', 'categories'])
            ->limit(5)
            ->get();

        return response()->json($promotions);
    }

    /**
     * Crear promoción (solo admin)
     */
    public function store(StorePromotionRequest $request)
    {
        $validated = $request->validated();

        $promotion = Promotion::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'discount_percentage' => $validated['discount_percentage'] ?? null,
            'discount_amount' => $validated['discount_amount'] ?? null,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'is_active' => $validated['is_active'] ?? true,
        ]);

        // 🔥 SINCRONIZAR PRODUCTOS
        if (!empty($validated['product_ids'])) {
            $promotion->products()->sync($validated['product_ids']);
        }

        // 🔥 SINCRONIZAR CATEGORÍAS
        if (!empty($validated['category_ids'])) {
            $promotion->categories()->sync($validated['category_ids']);
        }

        return response()->json($promotion->load('products','categories'), 201);
    }


    /**
     * Actualizar promoción (solo admin)
     */
    public function update(UpdatePromotionRequest $request, Promotion $promotion)
    {
        $validated = $request->validated();

        $promotion->update($validated);

        // 🔥 SINCRONIZAR PRODUCTOS (nueva funcionalidad)
        if (isset($validated['product_ids'])) {
            $promotion->products()->sync($validated['product_ids']);
        }

        // 🔥 SINCRONIZAR CATEGORÍAS (nueva funcionalidad)
        if (isset($validated['category_ids'])) {
            $promotion->categories()->sync($validated['category_ids']);
        }

        return response()->json($promotion->load('products', 'categories'));
    }

    /**
     * Eliminar promoción (solo admin)
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();

        return response()->json([
            'message' => 'Promoción eliminada correctamente'
        ]);
    }
}
