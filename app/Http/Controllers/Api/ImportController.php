<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    /**
     * Importar productos desde Excel/CSV
     * 
     * Formato esperado (primera fila = encabezados):
     * name, description, price, category_id, image
     */
    public function importProducts(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new ProductsImport, $request->file('file'));

            return response()->json([
                'message' => 'Productos importados exitosamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al importar: ' . $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Importar categorías desde Excel/CSV
     * 
     * Formato esperado (primera fila = encabezados):
     * name, description
     */
    public function importCategories(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new CategoriesImport, $request->file('file'));

            return response()->json([
                'message' => 'Categorías importadas exitosamente',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al importar: ' . $e->getMessage(),
            ], 422);
        }
    }
}

/**
 * Import class for Products
 */
class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Validar que tenga nombre
        if (empty($row['name'])) {
            return null;
        }

        // Generar slug único
        $slug = Str::slug($row['name']);
        $originalSlug = $slug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return new Product([
            'category_id' => $row['category_id'] ?? 1,
            'name' => $row['name'],
            'slug' => $slug,
            'description' => $row['description'] ?? null,
            'price' => floatval($row['price'] ?? 0),
            'image' => $row['image'] ?? null,
        ]);
    }
}

/**
 * Import class for Categories
 */
class CategoriesImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (empty($row['name'])) {
            return null;
        }

        $slug = Str::slug($row['name']);
        $originalSlug = $slug;
        $counter = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return new Category([
            'name' => $row['name'],
            'slug' => $slug,
            'description' => $row['description'] ?? null,
        ]);
    }
}
