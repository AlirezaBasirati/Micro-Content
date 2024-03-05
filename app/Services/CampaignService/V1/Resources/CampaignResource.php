<?php

namespace App\Services\CampaignService\V1\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @property mixed $id
 * @property string $name
 * @property string $slug
 * @property Collection $products
 */
class CampaignResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'slug'           => $this->slug,
            'products_count' => count($this->products),
        ];
    }
}
