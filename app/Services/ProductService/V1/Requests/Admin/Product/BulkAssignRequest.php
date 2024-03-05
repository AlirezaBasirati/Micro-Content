<?php

namespace App\Services\ProductService\V1\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class BulkAssignRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'filters'                => 'required|array',
            'detach'                 => 'required|boolean',
            'filters.except'         => 'array',
            'filters.except.*'       => 'required|integer',
            'filters.search'         => 'string',
            'filters.product_ids'    => 'array',
            'filters.product_ids.*'  => 'required|exists:products,id',
            'filters.category_ids'   => 'array',
            'filters.category_ids.*' => 'required|exists:categories,id',
            'filters.brand_id'       => 'exists:brands,id',
            'category_ids.*'         => 'required|exists:categories,id',
        ];
    }
}
