<?php

namespace App\Http\Requests\Branch;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class BranchStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'phone' => ['required_without:email', 'string', 'max:255', 'unique:branches,phone'],
            'email' => ['required_without:phone', 'email', 'string', 'max:255', 'unique:branches,email'],
            'contactPerson' => ['nullable', 'string',],
        ];
    }

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please provide the branch name.',
            'name.string' => 'Branch name must be a valid string.',
            'name.max' => 'Branch name cannot exceed 255 characters.',

            'address.required' => 'Please provide the branch address.',
            'address.string' => 'Address must be a valid string.',

            'phone.required_without' => 'Phone is required when email is not provided.',
            'phone.string' => 'Phone must be a valid string.',
            'phone.max' => 'Phone cannot exceed 255 characters.',

            'email.required_without' => 'Email is required when phone is not provided.',
            'email.email' => 'Please provide a valid email address.',
            'email.max' => 'Email cannot exceed 255 characters.',
            'email.unique' => 'This email address is already registered.',

            'contactPerson.string' => 'Contact person must be a valid string.',
        ];
    }

    /**
     * Friendly field names
     */
    public function attributes(): array
    {
        return [
            'name' => 'branch name',
            'address' => 'branch address',
            'phone' => 'phone number',
            'email' => 'email address',
            'contactPerson' => 'contact person',
        ];
    }
}
