<?php

namespace App\Services\ContentManagerService\V1\Requests\Admin\Slider;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'       => 'string',
            'type'        => 'string',
            'position_id' => 'integer',
            'status'      => 'integer',
            'height'      => 'string',
            'width'       => 'string',
        ];
    }
}
