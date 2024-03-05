<?php

namespace App\Services\ProductService\V1\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductImportRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => 'required|file',
        ];
    }
}
