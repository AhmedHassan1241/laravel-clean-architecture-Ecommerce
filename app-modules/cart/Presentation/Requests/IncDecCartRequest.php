<?php

namespace AppModules\Cart\Presentation\Requests;


use Illuminate\Foundation\Http\FormRequest;

class IncDecCartRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'productId' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|in:1'
        ];
    }

}
