<?php

namespace App\Services\ContentManagerService\V1\Resources\Admin\Faq;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $question
 * @property mixed $answer
 * @property mixed $status
 * @property mixed $id
 */
class FaqResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'       => $this->id,
            'question' => $this->question,
            'answer'   => $this->answer,
            'status'   => $this->status,
        ];
    }
}
