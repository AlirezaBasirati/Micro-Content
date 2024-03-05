<?php

namespace App\Services\ProductService\V1\Requests\Admin\Attribute;

use App\Services\ProductService\V1\Enumerations\Attribute\Type;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'              => 'string',
            'slug'               => 'string',
            'type'               => [new Enum(Type::class)],
            'attribute_group_id' => 'nullable|integer',
            'status'             => 'integer',
            'searchable'         => 'nullable|integer',
            'filterable'         => 'nullable|integer',
            'comparable'         => 'nullable|integer',
            'visible'            => 'nullable|integer',
        ];
    }
}
