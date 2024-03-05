<?php

namespace App\Services\ProductService\V1\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class ExtendedCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'                  => ['required', 'string'],
            'sku'                   => ['required', 'string', 'unique:products,sku'],
            'public_id'             => ['required', 'string', 'unique:products,public_id'],
            'url_key'               => ['required', 'string', 'unique:products,url_key'],
            'images'                => ['nullable', 'array'],
            'images.*'              => ['required', 'file'],
            'thumbnail'             => ['nullable', 'file'],
            'tax_class'             => ['required', 'string'],
            'categories'            => ['required', 'array'],
            'categories.*'          => ['integer'],
            'visibility'            => ['required', 'boolean'],
            'status'                => ['required', 'integer'],
            'max_in_cart'           => ['nullable', 'integer'],
            'min_in_cart'           => ['nullable', 'integer'],
            'brand_id'              => ['required', 'integer'],
            'attribute_value_ids'   => ['array'],
            'attribute_value_ids.*' => ['exists:attribute_values,id'],
        ];
    }
}
