<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:5|max:255',
            'code' => ['required', 'numeric', Rule::unique('products')->ignore($this->route()->product->code, 'code')],
            'brand' => 'required|min:2|max:30',
            'price' => 'required|regex:/^\d+$/',
            'stock' => 'required|integer|min:0',
            'description' => 'required|min:30',
        ];
    }
}
