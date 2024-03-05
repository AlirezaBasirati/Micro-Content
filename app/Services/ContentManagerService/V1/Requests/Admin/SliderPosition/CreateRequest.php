<?php

namespace App\Services\ContentManagerService\V1\Requests\Admin\SliderPosition;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'slug'  => 'required|string',
        ];
    }
}
