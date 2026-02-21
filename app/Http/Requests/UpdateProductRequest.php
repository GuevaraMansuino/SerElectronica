<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product') ?? $this->product;

        return [
            'category_id' => 'sometimes|exists:categories,id',
            'name' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|max:255|unique:products,slug,' . $productId . '|regex:/^[a-z0-9-]+$/',
            'description' => 'nullable|string|max:5000',
            'price' => 'sometimes|numeric|min:0|max:999999999',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
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
    }
}
