<?php

namespace App\Services\ContentManagerService\V1\Requests\Admin\Faq;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'question' => 'string',
            'answer' => 'string',
            'status' => 'boolean',
        ];
    }
}
