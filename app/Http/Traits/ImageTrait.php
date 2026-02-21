<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

trait ImageTrait
{
    /**
     * Guardar imagen desde request
     */
    protected function saveImage(Request $request, string $fieldName = 'image'): ?string
    {
        if (!$request->hasFile($fieldName)) {
            return $request->input($fieldName);
        }

        $file = $request->file($fieldName);

        // Validar tipo
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extension = strtolower($file->getClientOriginalExtension());
        
        if (!in_array($extension, $allowedTypes)) {
            return null;
        }

        // Generar nombre único
        $filename = Str::uuid() . '.' . $extension;

        // Guardar en storage/app/public/products
        $path = $file->storeAs('products', $filename, 'public');

        return $filename;
    }

    /**
     * Eliminar imagen anterior
     */
    protected function deleteImage(?string $filename): void
    {
        if (!$filename) {
            return;
        }

        $path = 'products/' . $filename;

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Validar imagen
     */
    protected function validateImage(Request $request, string $fieldName = 'image'): array
    {
        return $request->validate([
            $fieldName => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
        ]);
    }
}
