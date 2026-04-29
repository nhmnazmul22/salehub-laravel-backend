<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OTPVerifyRequest extends FormRequest
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
            'otp' => ['required', 'int', 'max_digits:6']
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Please provide a email for login',
            'email.email' => 'Please provide a valid email address',
            'email.exists' => 'No user found with this email',

            'otp.required' => 'Please provide a valid 6 digit otp',
            'otp.int' => 'OTP must be integer',
            'otp.max_digits' => 'OTP must be 6 digit integer',
        ];
    }
}
