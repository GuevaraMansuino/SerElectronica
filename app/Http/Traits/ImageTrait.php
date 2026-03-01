<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

trait ImageTrait
{
    /**
     * Manager de Intervention Image
     */
    protected function getImageManager(): ImageManager
    {
        return new ImageManager(new Driver());
    }

    /**
     * Guardar imagen desde request con procesamiento
     * Crea multiple tamanios y convierte a WebP
     * 
     * @return array|null Array con rutas o null si falla
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

        // Generar nombre único base
        $baseName = Str::uuid();

        // Definir tamanios
        $sizes = [
            'thumb' => ['width' => 300, 'height' => 300, 'suffix' => '_thumb'],
            'medium' => ['width' => 600, 'height' => 600, 'suffix' => '_medium'],
            'large' => ['width' => 1200, 'height' => 1200, 'suffix' => '_large'],
        ];

        $manager = $this->getImageManager();
        $image = $manager->read($file->getRealPath());
        
        // Obtener dimensiones originales
        $originalWidth = $image->width();
        $originalHeight = $image->height();

        // Guardar imagen original redimensionada (large)
        $largeImage = $manager->read($file->getRealPath());
        $largePath = $this->processAndSaveImage(
            $largeImage, 
            $sizes['large']['width'], 
            $sizes['large']['height'],
            $baseName,
            $sizes['large']['suffix'],
            'products'
        );

        // Guardar medium
        $mediumImage = $manager->read($file->getRealPath());
        $mediumPath = $this->processAndSaveImage(
            $mediumImage, 
            $sizes['medium']['width'], 
            $sizes['medium']['height'],
            $baseName,
            $sizes['medium']['suffix'],
            'products'
        );

        // Guardar thumbnail
        $thumbImage = $manager->read($file->getRealPath());
        $thumbPath = $this->processAndSaveImage(
            $thumbImage, 
            $sizes['thumb']['width'], 
            $sizes['thumb']['height'],
            $baseName,
            $sizes['thumb']['suffix'],
            'products'
        );

        // Retornar JSON con todas las rutas
        return json_encode([
            'original' => $largePath,
            'large' => $largePath,
            'medium' => $mediumPath,
            'thumb' => $thumbPath,
            'width' => $originalWidth,
            'height' => $originalHeight,
        ]);
    }

    /**
     * Procesar y guardar una imagen redimensionada
     */
    protected function processAndSaveImage($image, int $maxWidth, int $maxHeight, string $baseName, string $suffix, string $folder): string
    {
        // Redimensionar manteniendo aspect ratio
        $image->scaleDown($maxWidth, $maxHeight);

        // Convertir a WebP y guardar
        $filename = $baseName . $suffix . '.webp';
        $path = $folder . '/' . $filename;
        
        $image->toWebp(85)->save(storage_path('app/public/' . $path));

        return $path;
    }

    /**
     * Eliminar imagenes anteriores (todas las versiones)
     */
    protected function deleteImage(?string $imageData): void
    {
        if (!$imageData) {
            return;
        }

        // Si es JSON, decode para obtener todas las rutas
        $paths = json_decode($imageData, true);
        
        if ($paths && isset($paths['large'])) {
            // Eliminar todas las versiones
            $pathsToDelete = [
                $paths['large'] ?? null,
                $paths['medium'] ?? null,
                $paths['thumb'] ?? null,
            ];
        } else {
            // Legacy: solo una ruta
            $pathsToDelete = [$imageData];
        }

        foreach ($pathsToDelete as $path) {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }
    }

    /**
     * Validar imagen
     */
    protected function validateImage(Request $request, string $fieldName = 'image'): array
    {
        return $request->validate([
            $fieldName => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120', // Max 5MB
        ]);
    }

    /**
     * Obtener URL de una版本 especifica
     * 
     * @param string|null $imageData Datos JSON de la imagen
     * @param string $size thumb|medium|large|original
     * @return string|null
     */
    protected function getImageUrl(?string $imageData, string $size = 'medium'): ?string
    {
        if (!$imageData) {
            return null;
        }

        $paths = json_decode($imageData, true);
        
        if ($paths && isset($paths[$size])) {
            return asset('storage/' . $paths[$size]);
        }

        // Legacy: ruta directa
        if (is_string($imageData) && !str_starts_with($imageData, '{')) {
            return asset('storage/products/' . $imageData);
        }

        return null;
    }
}
