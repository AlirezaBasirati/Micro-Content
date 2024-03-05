<?php

namespace App\Services\ContentManagerService\V1\Requests\Admin\SliderPosition;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'       => 'string',
            'slug'        => 'string',
        ];
    }
}
