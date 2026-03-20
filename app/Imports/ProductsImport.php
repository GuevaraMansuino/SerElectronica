<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Resolver categoría: primero por nombre, luego por ID numérico
        $categoryId = 1; // valor por defecto

        if (!empty($row['category_name'])) {
            $category = Category::whereRaw('LOWER(TRIM(name)) = ?', [strtolower(trim($row['category_name']))])->first();
            if ($category) {
                $categoryId = $category->id;
            }
        } elseif (!empty($row['category_id']) && is_numeric($row['category_id'])) {
            $catId = (int) $row['category_id'];
            if (Category::where('id', $catId)->exists()) {
                $categoryId = $catId;
            }
        }

        // Generar slug desde el nombre
        $slug = Str::slug($row['name'] ?? 'product');

        // Asegurar slug único
        $originalSlug = $slug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return new Product([
            'category_id' => $categoryId,
            'name'        => $row['name'] ?? 'Sin nombre',
            'slug'        => $slug,
            'description' => $row['description'] ?? null,
            'price'       => floatval($row['price'] ?? 0),
            'image'       => $row['image'] ?? null,
        ]);
    }
}
