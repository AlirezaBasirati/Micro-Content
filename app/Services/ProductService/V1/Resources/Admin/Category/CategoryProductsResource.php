<?php

namespace App\Services\ProductService\V1\Resources\Admin\Category;

use App\Services\ProductService\V1\Resources\Admin\Product\ProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $id
 * @property mixed $title
 * @property mixed $parent_id
 * @property mixed $status
 * @property mixed $products
 * @property mixed $description
 * @property mixed $color
 */
class CategoryProductsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'parent_id'      => $this->parent_id,
            'status'         => $this->status,
            'color'          => $this->color,
            'description'    => $this->description,
            'products_count' => count($this->products),
            'products'       => ProductResource::collection($this->products),
        ];
    }
}
