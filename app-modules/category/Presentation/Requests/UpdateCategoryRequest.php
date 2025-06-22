<?php

namespace AppModules\Category\Presentation\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'slug' => [
                'sometimes',
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($this->route('id'))],
            'description' => 'sometimes|nullable|string',
            'is_active' => 'sometimes|nullable|boolean',
            'parent_id' => ['sometimes', 'nullable', 'exists:categories,id',
                function ($attribute, $value, $fail) {
                    if ((int)$value === (int)$this->route('id')) {
                        $fail('The Category Cannot Be Subordinate To Itself.');
                    }
                },]
        ];
    }

}
