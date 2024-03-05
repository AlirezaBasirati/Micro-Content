<?php

namespace App\Services\CommentService\V1\Requests\Client\Recommendation;

use App\Services\CommentService\V1\Enums\IsRecommendedStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class CreateRecommendation extends FormRequest
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
            'status' => ['required', new Enum(IsRecommendedStatus::class)],
        ];
    }
}
