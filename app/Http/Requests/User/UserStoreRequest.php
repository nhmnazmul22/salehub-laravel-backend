<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserStoreRequest extends FormRequest
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
            'firstName' => ['required', 'string', 'max:255'],
            'lastName' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'string', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->max(16)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'branchId' => ['nullable', 'integer', 'exists:branches,branchId'],
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'firstName.required' => 'Please provide the first name.',
            'firstName.string' => 'First name must be a valid string.',

            'lastName.required' => 'Please provide the last name.',
            'lastName.string' => 'Last name must be a valid string.',

            'email.required' => 'Please provide the email address.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email address is already registered.',

            'password.required' => 'Please provide a password.',
            'password.string' => 'Password must be a valid string.',

            'branchId.integer' => 'Branch ID must be a valid number.',
            'branchId.exists' => 'Selected branch does not exist.',
        ];
    }

    /**
     * Friendly field names
     */
    public function attributes(): array
    {
        return [
            'firstName' => 'first name',
            'lastName' => 'last name',
            'role' => 'role',
            'email' => 'email address',
            'password' => 'password',
            'branchId' => 'branch',
        ];
    }
}
