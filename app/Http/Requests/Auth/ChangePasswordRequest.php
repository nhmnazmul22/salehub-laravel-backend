<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'oldPassword' => [
                'required',
                'string',
                Password::min(8)
                    ->max(16)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'newPassword' => [
                'required',
                'string',
                Password::min(8)
                    ->max(16)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'newPassword_confirmation' => ['required', 'string']
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'oldPassword.required' => 'Please enter your current password',
            'oldPassword.string' => 'Current password must be a valid string',

            'newPassword.required' => 'Please enter a new password',
            'newPassword.string' => 'New password must be a valid string',

            'newPassword_confirmation.required' => 'Please confirm your new password',
            'newPassword_confirmation.string' => 'Confirmation password must be a valid string',
        ];
    }

    /**
     * Custom attribute names (for cleaner error messages)
     */
    public function attributes(): array
    {
        return [
            'oldPassword' => 'current password',
            'newPassword' => 'new password',
            'newPassword_confirmation' => 'password confirmation',
        ];
    }
}
