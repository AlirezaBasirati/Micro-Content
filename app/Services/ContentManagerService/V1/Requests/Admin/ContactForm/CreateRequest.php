<?php

namespace App\Services\ContentManagerService\V1\Requests\Admin\ContactForm;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'topic' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|string|email',
            'phone' => 'required|integer',
            'description' => 'required|string',
        ];
    }
}
