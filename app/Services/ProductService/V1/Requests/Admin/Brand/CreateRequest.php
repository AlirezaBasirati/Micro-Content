<?php

namespace App\Services\ProductService\V1\Requests\Admin\Brand;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'            => 'required|string',
            'slug'            => 'required|string',
            'thumbnail'       => 'nullable|file',
            'image'           => 'nullable|file',
            'manufactured_in' => 'nullable|string',
            'description'     => 'nullable|string',
            'status'          => 'sometimes|integer',
            'en_name'         => 'nullable|string',
            'is_featured'     => 'nullable|integer',
        ];
    }
}
