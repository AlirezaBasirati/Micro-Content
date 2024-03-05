<?php

namespace App\Services\ProductService\V1\Repository\Admin\Product;

use App\Events\ProductUpdate;
use App\Services\ProductService\V1\Enumerations\Product\Type;
use App\Services\ProductService\V1\Models\AttributeValue;
use App\Services\ProductService\V1\Models\FlatProduct;
use App\Services\ProductService\V1\Models\Product;
use App\Services\ProductService\V1\Models\ProductImage;
use App\Services\ProductService\V1\Repository\Admin\AttributeValue\AttributeValueServiceInterface;
use App\Services\ProductService\V1\Repository\Admin\Category\CategoryServiceInterface;
use Celysium\Media\Facades\Media;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Support\Facades\DB;

class ProductServiceRepository extends BaseRepository implements ProductServiceInterface
{
    public function __construct(
        Product $model,
        private readonly ProductImageServiceInterface $productImageService,
        private readonly CategoryServiceInterface $categoryService,
        private readonly AttributeValueServiceInterface $attributeValueService,
        private readonly ProductValueServiceInterface $productValueService
    )
    {
        parent::__construct($model);
    }

    public function query(Builder $query, array $parameters = []): Builder
    {
        if (isset($parameters['search']) && strlen($parameters['search']) > 0) {
            $query->where(function ($query) use ($parameters) {
                $query->where('name', 'LIKE', '%' . $parameters['search'] . '%');
                $query->orWhere('sku', 'LIKE', '%' . $parameters['search'] . '%');
            });
        }

        if (isset($parameters['product_ids']) && count($parameters['product_ids'])) {
            $query->whereIn('id', $parameters['product_ids']);
        }

        if (isset($parameters['brand_id'])) {
            $query->whereHas('brand', function ($query) use ($parameters) {
                $query->where('brands.id', $parameters['brand_id']);
            });
        }

        if (isset($parameters['except']) && count($parameters['except'])) {
            $query->whereNotIn('id', $parameters['except']);
        }

        if (isset($parameters['category_ids']) && count($parameters['category_ids'])) {
            $categories = collect();
            foreach ($parameters['category_ids'] as $categoryId) {
                $categories = $categories->merge($this->categoryService->getChildren($categoryId)->pluck('id'));
            }
            $query->whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('categories.id', $categories);
            });
        }

        if (isset($parameters['has_description'])) {
            if ($parameters['has_description'] == 0) {
                $query->whereNull('description');
            }
            else if ($parameters['has_description'] == 1) {
                $query->whereNotNull('description');
            }
        }

        if (isset($parameters['status'])) {
            $query->where('status', $parameters['status']);
        }

        if (isset($parameters['visibility'])) {
            $query->where('visibility', $parameters['visibility']);
        }

        if (isset($parameters['has_seo'])) {
            if ($parameters['has_seo'] == 0) {
                $query->where(function ($query) use ($parameters) {
                    $query->whereNull('meta_title');
                    $query->whereNull('meta_keywords');
                    $query->whereNull('meta_description');
                });
            }
            else if ($parameters['has_seo'] == 1) {
                $query->where(function ($query) use ($parameters) {
                    $query->whereNotNull('meta_title');
                    $query->orWhereNotNull('meta_keywords');
                    $query->orWhereNotNull('meta_description');
                });
            }
        }

        return $query;
    }

    public function store($parameters): model
    {
        if (!$parameters['url_key']) {
            $parameters['url_key'] = env('BASE_URL') . "/" . $parameters['sku'] . "/" . $parameters['name'];
        }

        return Product::query()->create($parameters);
    }

    private function storeProductValues($product, $product_attributes): void
    {
        $product_attributes = array_map(function ($product_attribute) use ($product) {
            $product_attribute['product_id'] = $product->id;
            return $product_attribute;
        }, $product_attributes);

        $this->productValueService->storeMany($product_attributes);
    }

    public function search($parameters): LengthAwarePaginator
    {
        return Product::search($parameters->get('query'))
            ->where('visibility', 1)
            ->where('status', 1)
            ->paginate($parameters->get('perPage'));
    }

    public function extendedCreate($parameters): Product
    {
        /** @var Product $product */
        if (!isset($parameters['url_key'])) {
            $parameters['url_key'] = "/" . $parameters['sku'] . "/" . str_replace(" ", "-", $parameters['name']);
        }

        if (!isset($parameters['tax_class'])) {
            $parameters['tax_class'] = 9;
        }

        if (isset($parameters['meta_keywords'])) {
            $parameters['meta_keywords'] = implode(",", $parameters['meta_keywords']);
        }

        DB::beginTransaction();

        /** @var Product $model */
        $model = Product::query()->create($parameters);

        if (isset($parameters['attribute_value_ids'])) {
            $product_attributes = $this->attributeValueService->productAttributes($parameters['attribute_value_ids']);
            $this->storeProductValues($model, $product_attributes);

            if ($this->attributeValueService->isConfigurable($parameters['attribute_value_ids'])) {
                $model->type = Type::CONFIGURABLE->value;
                $model->save();

                $variant_products = $this->attributeValueService->getVariantProducts($parameters['attribute_value_ids']);

                $parameters['master_id'] = $model->id;
                $sku = $parameters['sku'];
                $public_id = $parameters['public_id'];
                $parameters['type'] = Type::VARIANT->value;

                foreach ($variant_products as $key => $variant_product) {
                    $parameters['sku'] = "$key-$sku";
                    $parameters['public_id'] = "$key-$public_id";
                    $product = Product::query()->create($parameters);
                    $this->storeProductValues($product, $variant_product);

                    if (isset($parameters['categories'])) {
                        $this->assignCategories($product, $parameters['categories']);
                    }

                    if (isset($parameters['related_products'])) {
                        $this->addRelated($product, $parameters['related_products']);
                    }
                }
            }
        }

        if (isset($parameters['categories'])) {
            $this->assignCategories($model, $parameters['categories']);
        }

        if (isset($parameters['thumbnail'])) {
            $thumbnail = Media::upload($parameters['thumbnail']);
            ProductImage::query()->create([
                'product_id'   => $model->id,
                'is_thumbnail' => 1,
                'position'     => 1,
                'url'          => $thumbnail,
            ]);
        }

        if (isset($parameters['images'])) {
            $position = 2;
            foreach ($parameters['images'] as $image) {
                $media = Media::upload($image);

                $this->productImageService->addFile($model, $media, $position);
                $position++;
            }
        }

        if (isset($parameters['related_products'])) {
            $this->addRelated($model, $parameters['related_products']);
        }

        DB::commit();

        return $model;
    }


    public function extendedUpdate(Product $product, $parameters): Product
    {
        if (isset($parameters['meta_keywords'])) {
            $parameters['meta_keywords'] = implode(",", $parameters['meta_keywords']);
        }

        $product->update($parameters);

//        if (isset($parameters['attributes'])) {
//            $attributeValues = $parameters['attributes'];
//            foreach ($attributeValues as $attributeValue) {
//                if ($attributeValue['attribute_id'] && $attributeValue['value']) {
//                    /** @var AttributeValue $attributeValue */
//                    $attributeValue = AttributeValue::query()->firstOrCreate([
//                        'attribute_id' => $attributeValue['attribute_id'],
//                        'value'        => $attributeValue['value'],
//                    ]);
//
//                    /** @var Attribute $attribute */
//                    $attribute = Attribute::query()
//                        ->find($attributeValue['attribute_id']);
//                    if ($attribute) {
//                        $product->productValues()
//                            ->where('attribute_id', $attribute->id)
//                            ->whereNot('attribute_value_id', $attributeValue->id)
//                            ->delete();
//
//                        $this->assignAttribute($product, $attributeValue);
//                    }
//                }
//            }
//            $attributes = collect($attributeValues)->pluck('attribute_id');
//            $product->productValues()
//                ->whereNotIn('attribute_id', $attributes->toArray())
//                ->delete();
//        }

        if (isset($parameters['categories'])) {
            $this->assignCategories($product, $parameters['categories']);
        }

        if (isset($parameters['thumbnail'])) {
            ProductImage::query()
                ->where('product_id', $product->id)
                ->where('is_thumbnail', 1)
                ->update(['is_thumbnail' => 0]);

            $thumbnail = Media::upload($parameters['thumbnail']);

            ProductImage::query()->create([
                'product_id'   => $product->id,
                'is_thumbnail' => 1,
                'position'     => 1,
                'url'          => $thumbnail,
            ]);
        }

        if (isset($parameters['delete_images'])) {
            ProductImage::query()->whereIn('url', $parameters['delete_images'])->delete();
        }

        if (isset($parameters['images'])) {
            $position = $product->images()->max('position') ?? 2;
            foreach ($parameters['images'] as $image) {
                $media = Media::upload($image);

                $this->productImageService->addFile($product, $media, $position);
                $position++;
            }
        }

        if (isset($parameters['related_products'])) {
            $this->addRelated($product, $parameters['related_products']);
        }

        return $product;
    }

    public function listWithCategories(array $productIds): Collection
    {
        return Product::query()
            ->whereIn('id', $productIds)
            ->with('categories')
            ->get();
    }

    public function assignAttribute(Product $product, AttributeValue $attributeValue): Product
    {
        $product->productValues()->updateOrCreate([
            'product_id'         => $product->id,
            'attribute_id'       => $attributeValue->attribute_id,
            'attribute_value_id' => $attributeValue->id,
        ]);

        return $product;
    }

    public function unassignAttribute(Product $product, AttributeValue $attributeValue): Product
    {
        $product->productValues()
            ->where('attribute_value_id', $attributeValue->id)
            ->where('attribute_id', $attributeValue->id)
            ->delete();

        return $product;
    }

    public function assignCategories(Product $product, array $categoryIds, $detaching = false): Product
    {
        $product->categories()->sync($categoryIds, $detaching);

        return $product;
    }

    public function unassignCategories(Product $product, array $categoryIds): Product
    {
        $product->categories()->detach($categoryIds);

        return $product;
    }

    public function addConfigurable(Product $product, array $productIds): Product
    {
        Product::query()
            ->whereIn('id', $productIds)
            ->update(['master_id' => $product->id]);

        $product->update(['type' => Type::CONFIGURABLE]);

        return $product;
    }

    public function removeConfigurable(Product $product, array $productIds): Product
    {
        Product::query()
            ->whereIn('id', $productIds)
            ->update(['master_id' => null]);

        return $product;
    }

    public function addBundles(Product $product, array $parameters): Product
    {
        foreach ($parameters as $parameter) {
            $product->bundles()
                ->syncWithoutDetaching([
                    $parameter['child_id'] => [
                        'quantity' => $parameter['quantity'],
                        'price'    => $parameter['price'],
                    ]
                ]);
        }
        $product->update(['type' => 'bundle']);

        return $product;
    }

    public function removeBundles(Product $product, array $productIds): Product
    {
        $product->bundles()->detach($productIds);

        return $product;
    }

    public function addRelated(Product $product, array $productIds): Product
    {
        $product->related()->sync($productIds);

        return $product;
    }

    public function removeRelated(Product $product, array $productIds): Product
    {
        $product->related()->detach($productIds);

        return $product;
    }

    public function bulkUpdate(array $parameters): void
    {
        foreach ($parameters['product_ids'] as $parameter) {
            Product::query()->where('sku', $parameter)
                ->update([
                    'visibility' => $parameters['visibility'] == 1 ? Product::VISIBILITY_VISIBLE : Product::VISIBILITY_INVISIBLE,
                    'status'     => $parameters['status'] == 1 ? Product::STATUS_ACTIVE : Product::STATUS_INACTIVE,
                ]);
            FlatProduct::query()->where('sku', $parameter)
                ->update([
                    'visibility' => $parameters['visibility'] == 1 ? FlatProduct::VISIBILITY_VISIBLE : FlatProduct::VISIBILITY_INVISIBLE,
                    'status'     => $parameters['status'] == 1 ? FlatProduct::STATUS_ACTIVE : FlatProduct::STATUS_INACTIVE,
                ]);
        }
    }

    public function bulkProductCategoryAssign(array $parameters): int
    {
        $parameters['filters']['export_type'] = 'collection';
        $products = $this->index($parameters['filters']);

        foreach ($products as $product) {
            $this->assignCategories($product, $parameters['category_ids'], $parameters['detach']);
            event(new ProductUpdate($product));
        }

        return $products->count();
    }
}
