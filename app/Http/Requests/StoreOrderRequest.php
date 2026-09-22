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
            'customer_phone' => ['required', 'string', 'max:20', 'regex:/^(\+?62|0)8[0-9]{8,13}$/'],
            'payment_method' => ['required', 'string', 'in:qris,wa'],
            'pickup_date' => ['required', 'date', 'after_or_equal:today'],
            'pickup_time' => ['required', 'date_format:H:i'],
            'bakery_request' => ['nullable', 'string', 'max:1000'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.group_id' => ['required', 'string'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:999'],
            'items.*.variant' => ['nullable', 'string'],
            'items.*.package' => ['nullable', 'string'],
            'items.*.add_ons' => ['nullable', 'array'],
            'items.*.add_ons.*' => ['nullable', 'string'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'customer_phone.regex' => 'Nomor WhatsApp tidak valid. Gunakan format Indonesia (contoh: 08113996988).',
        ];
    }
}
