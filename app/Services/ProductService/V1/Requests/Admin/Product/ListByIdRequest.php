<?php

namespace App\Services\ProductService\V1\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class ListByIdRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_ids' => 'required|array',
        ];
    }
}
