<?php

namespace App\Http\Requests\Api\v1;

use App\Enums\OrderStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
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
            'status' => ['required', Rule::enum(OrderStatusEnum::class)],
            'items' => 'required|array',
            'items.*.product_id' => 'required|numeric|exists:products,id',
            'items.*.quantity' => 'required|integer|min:0',
        ];
    }

    public function attributes(): array
    {
        return [
            'items.*.product_id' => 'item product_id',
            'items.*.quantity' => 'item quantity',
        ];
    }
}
