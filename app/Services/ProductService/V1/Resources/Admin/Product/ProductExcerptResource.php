<?php

namespace App\Services\ProductService\V1\Resources\Admin\Product;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $status
 * @property mixed $name
 * @property mixed $sku
 * @property mixed $description
 * @property mixed $brand
 * @property mixed $categories
 * @property mixed $thumbnail
 */
class ProductExcerptResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'categories' => $this->categories->pluck('id'),
        ];
    }
}
