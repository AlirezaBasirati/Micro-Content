<?php

namespace App\Services\CommentService\V1\Resources\Client\Comment;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

/**
 * @property Integer $id
 * @property Integer $comment_id
 * @property String $file
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class ImageResource extends JsonResource
{
    public function toArray($request): array|JsonSerializable|Arrayable
    {
        return [
            'id'         => $this->id,
            'comment_id' => $this->comment_id,
            'file'       => $this->file,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
