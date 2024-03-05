<?php

namespace App\Services\ContentManagerService\V1\Requests\Admin\SliderItem;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'     => 'required|string',
            'slider_id' => 'required|integer',
            'url'       => 'string',
            'status'    => 'integer',
            'image'     => 'file',
        ];
    }
}
