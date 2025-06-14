<?php

namespace AppModules\User\Presentation\Requests;

use AppModules\User\Infrastructure\Persistence\Models\UserModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
{

    public function authorize(): bool
    {
        $user = UserModel::find($this->route('id'));

        // Deny access if user not found
        if (!$user) {
            throw new HttpResponseException(
                response()->json(['message' => 'User Not Found.'], 404)
            );
        }

        return true;
    }

    public function rules(): array
    {
//        return [
//            'name' => 'sometimes|string|max:255',
//            'email'=>'sometimes|email|unique:users,email,'. $this->route('id'),
//            'password' => 'sometimes|string|min:8',
//        ];
        return [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $this->route('id'),
            'password' => 'sometimes|string|min:8'
        ];
    }
}
