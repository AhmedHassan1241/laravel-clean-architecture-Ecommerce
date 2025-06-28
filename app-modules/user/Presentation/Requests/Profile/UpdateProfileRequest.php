<?php

namespace AppModules\User\Presentation\Requests\Profile;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;


class UpdateProfileRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'phone' => 'sometimes|string|max:15',
            'address' => 'sometimes|string|max:100',
            'date_of_birth' => 'sometimes|date',
            'bio' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp,svg|max:2048'
        ];
    }

}
