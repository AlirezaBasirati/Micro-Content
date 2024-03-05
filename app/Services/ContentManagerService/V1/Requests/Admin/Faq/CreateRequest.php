<?php

namespace App\Services\ContentManagerService\V1\Requests\Admin\Faq;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'question' => 'required|string',
            'answer' => 'required|string',
            'status' => 'boolean',
        ];
    }
}
