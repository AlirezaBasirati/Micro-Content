<?php

namespace App\Services\CommentService\V1\Resources\Client\Comment;

use App\Services\CommentService\V1\Models\Comment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Integer $id
 * @property Integer $user_id
 * @property Integer $parent_id
 * @property String $title
 * @property String $body
 * @property Integer $status
 * @property array $positive_points
 * @property array $negative_points
 * @property integer $rate
 * @property Integer $product_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property Comment $parent
 * @property Collection $children
 * @property Collection $images
 * @property array $product
 * @property mixed $full_name
 */
class CommentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'              => $this->id,
            'user_id'         => $this->user_id,
            'full_name'       => $this->full_name,
            'parent_id'       => $this->parent_id,
            'title'           => $this->title,
            'body'            => $this->body,
            'status'          => $this->status,
            'positive_points' => $this->positive_points,
            'negative_points' => $this->negative_points,
            'rate'            => $this->rate,
            'product_id'      => $this->product_id,
            'children'        => CommentChildrenResource::collection($this->children),
            'images'          => ImageResource::collection($this->images),
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at,
            'product'         => $this->whenNotNull($this->product)
        ];
    }
}
