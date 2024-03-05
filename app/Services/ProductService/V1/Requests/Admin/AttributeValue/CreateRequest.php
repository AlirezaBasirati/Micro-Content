<?php

namespace App\Services\ProductService\V1\Requests\Admin\AttributeValue;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'attribute_id' => 'required|integer',
            'value'        => 'required|string',
            'image'        => 'nullable|file',
            'name'      => 'nullable|string',
        ];
    }
}
