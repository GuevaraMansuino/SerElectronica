<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePromotionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string|max:1000',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'start_date' => 'sometimes|date|before_or_equal:end_date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
            'is_active' => 'boolean',
            'product_ids' => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'start_date.before_or_equal' => 'La fecha de inicio debe ser anterior o igual a la fecha fin.',
            'end_date.after_or_equal' => 'La fecha fin debe ser posterior o igual a la fecha de inicio.',
            'discount_percentage.min' => 'El porcentaje no puede ser negativo.',
            'discount_percentage.max' => 'El porcentaje no puede superar 100.',
            'discount_amount.min' => 'El monto no puede ser negativo.',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $promotion = $this->route('promotion');
            
            $hasPercentage = !empty($this->discount_percentage);
            $hasAmount = !empty($this->discount_amount);
            $hadPercentage = $promotion && !empty($promotion->discount_percentage);
            $hadAmount = $promotion && !empty($promotion->discount_amount);

            if (!$hasPercentage && !$hasAmount && !$hadPercentage && !$hadAmount) {
                $validator->errors()->add('discount', 'Debe proporcionar un descuento porcentual o un monto.');
            }
        });
    }

    protected function prepareForValidation(): void
    {
        if ($this->discount_percentage !== null && $this->discount_percentage !== '') {
            $this->merge([
                'discount_percentage' => round(floatval($this->discount_percentage), 2)
            ]);
        }

        if ($this->discount_amount !== null && $this->discount_amount !== '') {
            $this->merge([
                'discount_amount' => round(floatval($this->discount_amount), 2)
            ]);
        }

        if ($this->start_date) {
            $this->merge([
                'start_date' => date('Y-m-d', strtotime($this->start_date))
            ]);
        }

        if ($this->end_date) {
            $this->merge([
                'end_date' => date('Y-m-d', strtotime($this->end_date))
            ]);
        }
    }
}
