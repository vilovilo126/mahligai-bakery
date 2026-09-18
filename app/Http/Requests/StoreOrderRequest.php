<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'payment_method' => ['required', 'string', 'in:qris,wa'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.group_id' => ['required', 'string'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:999'],
            'items.*.variant' => ['nullable', 'string'],
            'items.*.package' => ['nullable', 'string'],
            'items.*.add_ons' => ['nullable', 'array'],
            'items.*.add_ons.*' => ['nullable', 'string'],
        ];
    }
}
