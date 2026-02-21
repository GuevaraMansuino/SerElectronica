<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Generar slug desde el nombre
        $slug = Str::slug($row['name'] ?? 'product');

        // Asegurar slug único
        $originalSlug = $slug;
        $counter = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return new Product([
            'category_id' => $row['category_id'] ?? 1,
            'name' => $row['name'] ?? 'Sin nombre',
            'slug' => $slug,
            'description' => $row['description'] ?? null,
            'price' => floatval($row['price'] ?? 0),
            'image' => $row['image'] ?? null,
        ]);
    }
}
