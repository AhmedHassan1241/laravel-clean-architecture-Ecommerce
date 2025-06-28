<?php

namespace AppModules\Product\Presentation\Requests;


use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        return [
            'name' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|max:255|unique:products,slug,' . $this->route('id'),
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
            'sku' => 'sometimes|string|max:255|unique:products,sku,' . $this->route('id'),
            'is_active' => 'sometimes|boolean',
            'is_featured' => 'sometimes|boolean',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif,webp,svg|max:2048',
            'categories' => 'sometimes|array',
            'categories.*' => 'exists:categories,id'
        ];
    }

}
