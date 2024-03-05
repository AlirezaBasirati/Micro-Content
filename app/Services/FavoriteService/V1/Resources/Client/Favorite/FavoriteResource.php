<?php

namespace App\Services\FavoriteService\V1\Resources\Client\Favorite;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property integer $user_id
 * @property integer $product_id
 * @property array $product
 */
class FavoriteResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'product_id' => $this->product_id,
            'product'    => $this->whenNotNull($this->product)
        ];
    }
}
