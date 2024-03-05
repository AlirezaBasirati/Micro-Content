<?php

namespace App\Services\ProductService\V1\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'                => ['required', 'string'],
            'sku'                 => ['required', 'string'],
            'public_id'           => ['required', 'string'],
            'type'                => ['required', 'string'],
            'url_key'             => ['required', 'string'],
            'tax_class'           => ['required', 'string'],
            'description'         => ['nullable', 'string'],
            'brand_id'            => ['required', 'integer'],
            'status'              => ['nullable', 'integer'],
            'visibility'          => ['nullable', 'integer'],
            'max_in_cart'         => ['nullable', 'integer'],
            'min_in_cart'         => ['nullable', 'integer'],
            'attribute_value_ids' => ['exists:attribute_values']
        ];
    }
}
