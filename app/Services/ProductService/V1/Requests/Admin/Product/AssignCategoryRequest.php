<?php

namespace App\Services\ProductService\V1\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class AssignCategoryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'category_ids' => 'required|array',
        ];
    }
}
