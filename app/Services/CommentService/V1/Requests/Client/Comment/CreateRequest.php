<?php

namespace App\Services\CommentService\V1\Requests\Client\Comment;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'parent_id'         => ['integer', 'exists:comments,id'],
            'title'             => ['string'],
            'body'              => ['required', 'string'],
            'positive_points'   => ['array'],
            'negative_points'   => ['array'],
            'positive_points.*' => ['string'],
            'negative_points.*' => ['string'],
            'rate'              => ['required', 'integer', 'between:0,5'],
            'product_id'        => ['required', 'integer'],
            'files'             => ['nullable', 'array'],
            'files.*'           => ['required', 'file'],
        ];
    }
}
