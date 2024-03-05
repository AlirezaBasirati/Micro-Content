<?php

namespace App\Services\CommentService\V1\Requests\Client\Rating;

use Illuminate\Foundation\Http\FormRequest;

class CreateRating extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'score' => ['required', 'integer', 'between:0,5']
        ];
    }
}
