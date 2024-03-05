<?php

namespace App\Services\ProductService\V1\Resources\Admin\DraftProduct;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $sku
 */
class DraftProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
            'sku'  => $this->sku,
        ];
    }
}
