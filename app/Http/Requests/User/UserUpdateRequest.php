<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'firstName' => ['sometimes', 'string', 'max:255'],
            'lastName' => ['sometimes', 'string', 'max:255'],
            'role' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'string', 'max:255', 'unique:users,email'],
            'isActive' => ['sometimes', 'boolean:'],
            'branchId' => ['sometimes', 'integer', 'exists:branches,branchId'],
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'firstName.string' => 'First name must be a valid string.',

            'lastName.string' => 'Last name must be a valid string.',

            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email address is already registered.',

            'branchId.integer' => 'Branch ID must be a valid number.',
            'branchId.exists' => 'Selected branch does not exist.',

            'isActive.boolean' => 'isActive must be a valid boolean.'
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
            'branchId' => 'branch',
            'isActive' => 'status'
        ];
    }
}
