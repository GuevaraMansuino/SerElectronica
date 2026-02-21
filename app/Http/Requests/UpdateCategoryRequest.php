<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $categoryId = $this->route('category') ?? $this->category;
        
        return [
            'name' => 'sometimes|string|max:255|unique:categories,name,' . $categoryId,
            'slug' => 'sometimes|string|max:255|unique:categories,slug,' . $categoryId . '|regex:/^[a-z0-9-]+$/',
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'slug.regex' => 'El slug solo puede contener letras minúsculas, números y guiones.',
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->slug) {
            $this->merge([
                'slug' => strtolower(trim($this->slug))
            ]);
        }
    }

}
