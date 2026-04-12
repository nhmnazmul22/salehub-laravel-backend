<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class LoginRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->max(16)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Please provide a email for login',
            'email.email' => 'Please provide a valid email address',
            'email.exists' => 'No user found with this email',

            'password.required' => 'Please provide your password for login',
            'password.string' => 'Password must be a string',
        ];
    }
}
