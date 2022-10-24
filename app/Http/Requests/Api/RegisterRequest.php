<?php

namespace App\Http\Requests\Api;

use App\Models\User;
use App\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'username' => ['required', Rule::unique(User::getTableName())],
            'email' => ['required', 'email', Rule::unique(User::getTableName())],
            'password' => [
                'required', 'min:8', 'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
            ],
            'password_confirmation' => [
                'required', 'min:8'
            ]
        ];
    }

    public function bodyParameters()
    {
        return [
            'name' => [
                'description' => 'Name of the user',
            ],
            'username' => [
                'description' => 'Username of the user, used to login.',
            ],
            'email' => [
                'description' => 'Email of the user',
            ],
            'password' => [
                'description' => 'Password of the user',
                'example' => '1234passWORD'
            ],
            'password_confirmation' => [
                'description' => 'Confirmation Password of the user',
                'example' => '1234passWORD'
            ]
        ];
    }
}
