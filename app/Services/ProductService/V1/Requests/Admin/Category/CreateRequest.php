<?php

namespace App\Services\ProductService\V1\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'           => 'required|string',
            'parent_id'       => 'required|integer',
            'slug'            => 'required|string',
            'icon'            => 'nullable|file',
            'image'           => 'nullable|file',
            'description'     => 'nullable|string',
            'color'           => 'nullable|string',
            'status'          => 'required|integer',
            'position'        => 'sometimes|integer',
            'en_name'         => 'nullable|string',
            'visible_in_menu' => 'nullable|integer',
        ];
    }
}
