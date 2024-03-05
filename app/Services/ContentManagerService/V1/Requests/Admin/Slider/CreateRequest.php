<?php

namespace App\Services\ContentManagerService\V1\Requests\Admin\Slider;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'       => 'required|string',
            'type'        => 'required|string',
            'position_id' => 'required|integer',
            'status'      => 'integer',
            'height'      => 'string',
            'width'       => 'string',
        ];
    }
}
