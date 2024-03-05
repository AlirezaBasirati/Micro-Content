<?php

namespace App\Services\ProductService\V1\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class FetchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'sku'         => 'required|string',
            'store_id'    => 'required|integer',
            'merchant_id' => 'required|integer',
        ];
    }
}
