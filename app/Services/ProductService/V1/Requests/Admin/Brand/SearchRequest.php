<?php

namespace App\Services\ProductService\V1\Requests\Admin\Brand;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'query' => 'required|string|min:1'
        ];
    }
}
