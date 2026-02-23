<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug|regex:/^[a-z0-9-]+$/',
            'description' => 'nullable|string|max:5000',
            'price' => 'required|numeric|min:0|max:999999999',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'marca' => 'nullable|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'is_new' => 'boolean',
            'destacado' => 'boolean',
            'is_active' => 'boolean',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'slug.regex' => 'El slug solo puede contener letras minúsculas, números y guiones.',
            'price.min' => 'El precio no puede ser negativo.',
            'price.max' => 'El precio excede el límite permitido.',
            'image.max' => 'La imagen no puede superar 2MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Generar slug automáticamente desde el nombre si no existe
        if (!$this->slug && $this->name) {
            $this->merge([
                'slug' => \Illuminate\Support\Str::slug($this->name)
            ]);
        }

        if ($this->slug) {
            $this->merge([
                'slug' => strtolower(trim($this->slug))
            ]);
        }

        if ($this->price) {
            $this->merge([
                'price' => round(floatval($this->price), 2)
            ]);
        }

        // Manejar checkboxes: si no vienen, son false
        $this->merge([
            'is_new' => $this->has('is_new'),
            'destacado' => $this->has('destacado'),
            'is_active' => $this->has('is_active'),
        ]);
    }
}
