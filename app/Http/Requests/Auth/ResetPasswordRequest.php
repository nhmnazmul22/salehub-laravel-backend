<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'token' => ['required', 'string'],

            'newPassword' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->max(16)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],

            'newPassword_confirmation' => ['required', 'string'],
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Please enter your email address',
            'email.email' => 'Please enter a valid email address',
            'email.exists' => 'No account found with this email',

            'token.required' => 'Reset token is required',

            'newPassword.required' => 'Please enter a new password',
            'newPassword.confirmed' => 'Password confirmation does not match',

            'newPassword_confirmation.required' => 'Please confirm your new password',
        ];
    }

    /**
     * Friendly field names
     */
    public function attributes(): array
    {
        return [
            'email' => 'email address',
            'token' => 'reset token',
            'newPassword' => 'new password',
            'newPassword_confirmation' => 'password confirmation',
        ];
    }
}
