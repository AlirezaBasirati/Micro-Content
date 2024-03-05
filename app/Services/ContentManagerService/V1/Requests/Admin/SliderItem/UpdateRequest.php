<?php

namespace App\Services\ContentManagerService\V1\Requests\Admin\SliderItem;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'     => 'string',
            'slider_id' => 'integer',
            'url'       => 'string',
            'status'    => 'integer',
            'image'     => 'file',
        ];
    }
}
