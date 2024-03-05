<?php

namespace App\Services\ProductService\V1\Resources\Admin\Widget;

use App\Services\ProductService\V1\Models\FlatProduct;
use App\Services\ProductService\V1\Resources\Admin\FlatProduct\FlatProductResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

/**
 * @property mixed $id
 * @property string $name
 * @property string $slug
 * @property Collection $products
 */
class WidgetResource extends JsonResource
{
    public function toArray($request): array
    {
        $products = FlatProduct::query()
            ->whereIn('sku', $this->products->pluck('sku')->toArray())
            ->where('store_id', (int)$request->get('store_id'))
            ->get();
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'slug'     => $this->slug,
            'products' => FlatProductResource::collection($products),
        ];
    }
}
