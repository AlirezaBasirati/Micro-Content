<?php

namespace App\Services\ProductService\V1\Resources\Admin\FlatProduct;

use App\Services\ProductService\V1\Models\Brand;
use App\Services\ProductService\V1\Models\Category;
use App\Services\ProductService\V1\Models\FlatProduct;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

/**
 * @property mixed $store_id
 * @property integer id
 * @property string name
 * @property string sku
 * @property array $gallery
 * @property Brand brand
 * @property mixed $brand_id
 * @property mixed $type
 * @property mixed $price_original
 * @property mixed $price_promoted
 * @property mixed $max_in_cart
 * @property mixed $description
 * @property mixed $status
 * @property array $categories
 * @property array $attributes
 * @property mixed $quantity
 * @property mixed $is_in_stock
 * @property mixed $view_count
 * @property mixed $master_id
 * @property mixed $tax_class
 * @property mixed $visibility
 * @property mixed $barcode
 * @property mixed $color
 * @property mixed $dimensions
 * @property mixed $meta_title
 * @property mixed $meta_keyword
 * @property mixed $meta_description
 * @property mixed $merchant_id
 * @property mixed $merchant
 * @property mixed $bundle_products
 * @property mixed $related_products
 *; @property mixed $batch_id
 */
class DeepFlatProductResource extends JsonResource
{
    public function toArray($request): array
    {
        $relatedProducts = collect();
        if ($this->related_products) {
            $relatedProducts = FlatProduct::query()->whereIn('id', $this->related_products)->get();
        } else if (count($this->categories) > 0) {
            $subCategory = max($this->categories);
            $relatedProducts = FlatProduct::query()
                ->where('categories', $subCategory)
                ->where('sku', '!=', $this->sku)
                ->take(5)
                ->get();
        }

        $variants = FlatProduct::query()->where('master_id', $this->id)->get();

        $bundle = null;
        if ($this->bundle_products && count($this->bundle_products) > 0) {
            $bundle = FlatProduct::query()->whereIn('id', Arr::pluck($this->bundle_products, 'id'))
                ->get()
                ->map(function ($bundleProduct) {
                    $bundleInfo = current(Arr::where($this->bundle_products, function ($item) use ($bundleProduct) {
                        return $item['id'] == $bundleProduct['id'];
                    }));
                    $bundleProduct->price = (int)$bundleInfo['price'];
                    $bundleProduct->bundle_quantity = $bundleInfo['quantity'];
                    return $bundleProduct;
                });
        }

        $thumbnail = collect($this->gallery)->where('is_thumbnail', 1)->first();

        $category = Arr::last($this->categories);

        $attributes = [];
        foreach ($this->attributes as $attribute) {
            $attributes[$attribute['slug']] = $attribute;
        }

        return [
            'store_id'           => $this->store_id,
            'merchant_id'        => $this->merchant_id,
            'merchant'           => $this->merchant,
            'id'                 => $this->id,
            'type'               => $this->type,
            'name'               => $this->name,
            'sku'                => $this->sku,
            'batch_id'           => $this->batch_id,
            'price_original'     => $this->price_original,
            'price_promoted'     => $this->price_promoted,
            'discounted_percent' => $this->discounted_percent,
            'max_in_cart'        => $this->max_in_cart ? min($this->max_in_cart, $this->quantity) : $this->quantity,
            'is_in_stock'        => $this->is_in_stock,
            'master'             => $this->configurable ? new FlatProductResource($this->configurable) : null,
            'master_id'          => $this->master_id,
            'quantity'           => $this->quantity,
            'description'        => $this->description,
            'status'             => $this->status,
            'gallery'            => $this->gallery,
            'thumbnail'          => $thumbnail,
            'tax_class'          => $this->tax_class,
            'visibility'         => $this->visibility,
            'barcode'            => $this->barcode ?? null,
            'color'              => $this->color ?? null,
            'dimensions'         => $this->dimensions ?? null,
            'meta_title'         => $this->meta_title ?? null,
            'meta_keyword'       => $this->meta_keyword ?? null,
            'meta_description'   => $this->meta_description ?? null,
            'brand_name'         => $this->brand->name ?? null,
            'brand_id'           => $this->brand->id ?? null,
            'view_count'         => $this->view_count,
            'category'           => $category,
            'attributes'         => $attributes,
            'variants'           => FlatProductResource::collection($variants),
            'bundle'             => ($bundle) ? FlatProductBundleResource::collection($bundle) : null,
            'related_products'   => FlatProductExcerptResource::collection($relatedProducts),
        ];
    }
}
