<?php

namespace App\Services\ProductService\V1\Requests\Admin\AttributeValue;

use Illuminate\Foundation\Http\FormRequest;

class DetailRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ids'   => ['required', 'array'],
            'ids.*' => ['required', 'exists:attribute_values,id'],
        ];
    }
}
