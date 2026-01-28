<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
        return [
             'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'brand_id'    => 'required|exists:brands,id',

            'variants'               => 'required|array|min:1',
            'variants.*.sku'         => 'required|string|distinct',
            'variants.*.flavor'      => 'nullable|string',
            'variants.*.size'        => 'nullable|string',
            'variants.*.price'       => 'required|numeric|min:0',
            'variants.*.stock'       => 'required|integer|min:0',
            'variants.*.expiration_date' => 'nullable|date',
        ];
    }
}
