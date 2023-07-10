<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_id' => ['required', 'integer'],
            'size' => ['nullable', 'string'],
            'color' => ['nullable', 'json'],
            'image' => ['nullable', 'image'],
            'stock' => ['required', 'numeric'],
            'plus' => ['required', 'boolean'],
            'extra_plus' => ['nullable', 'numeric']
        ];
    }
}
