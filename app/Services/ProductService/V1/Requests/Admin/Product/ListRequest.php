<?php

namespace App\Services\ProductService\V1\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class ListRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'products'               => 'required|array',
            'products.*.sku'         => 'required|string',
            'products.*.store_id'    => 'required|numeric',
            'products.*.merchant_id' => 'nullable|numeric',
        ];
    }
}
