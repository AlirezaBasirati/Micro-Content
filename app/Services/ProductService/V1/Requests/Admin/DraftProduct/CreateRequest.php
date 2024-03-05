<?php

namespace App\Services\ProductService\V1\Requests\Admin\DraftProduct;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'articleNumber'      => 'required|string',
            'articleDescription' => 'required|string',
        ];
    }
}
