<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
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
            'name' => ['string', 'required', 'max:120'],
            'image' => ['nullable', 'url'],
            'isActive' => ['sometimes', 'boolean']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'image.url' => 'Image must be a valid URL string',
            'isActive.boolean' => 'Is Active must be true or false'
        ];
    }
}
