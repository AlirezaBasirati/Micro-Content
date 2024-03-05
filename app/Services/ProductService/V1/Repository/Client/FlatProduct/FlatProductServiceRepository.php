<?php

namespace App\Services\ProductService\V1\Repository\Client\FlatProduct;

use App\Services\CampaignService\V1\Models\Campaign;
use App\Services\ProductService\V1\Enumerations\Product\Type;
use App\Services\ProductService\V1\Models\Attribute;
use App\Services\ProductService\V1\Models\AttributeValue;
use App\Services\ProductService\V1\Models\Category;
use App\Services\ProductService\V1\Models\FlatCategory;
use App\Services\ProductService\V1\Models\FlatProduct;
use App\Services\ProductService\V1\Models\OrderedProduct;
use App\Services\ProductService\V1\Models\Product;
use App\Services\ProductService\V1\Models\ProductValue;
use App\Services\ProductService\V1\Models\Search;
use App\Services\SpecialOfferService\V1\Models\SpecialOffer;
use Celysium\Authenticate\Facades\Authenticate;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class FlatProductServiceRepository extends BaseRepository implements FlatProductServiceInterface
{
    public function __construct(FlatProduct $model)
    {
        $model->setPerPage(20);
        parent::__construct($model);
    }

    public function index(array $parameters = [], array $columns = ['*']): LengthAwarePaginator|Collection
    {
        $query = $this->model->query();

        $query->options(['allowDiskUse' => true]);

        $query->whereIn('type', [Type::BUNDLE->value, Type::SIMPLE->value, Type::CONFIGURABLE->value]);

        if (isset($parameters['search'])) {
            $query->where(function ($query) use ($parameters) {
                $query->where('name', 'LIKE', '%' . $parameters['search'] . '%');
                $query->orWhere('sku', 'LIKE', '%' . $parameters['search'] . '%');
            });
        }

        if (isset($parameters['campaign'])) {
            /** @var Campaign $campaign */
            $campaign = Campaign::query()
                ->where('slug', $parameters['campaign'])
                ->firstOrNew();

            $query->whereIn('id', $campaign->products->pluck('id')->toArray());
        }

        if (isset($parameters['campaign_id'])) {
            /** @var Campaign $campaign */
            $campaign = Campaign::query()
                ->where('id', $parameters['campaign_id'])
                ->firstOrNew();

            $query->whereIn('id', $campaign->products->pluck('id')->toArray());
        }

        if (isset($parameters['mega_campaign'])) {
            if ($parameters['mega_campaign'] == 'special-offer') {
                $specialOfferProductIds = SpecialOffer::query()->available()->pluck('product_id');
                $query->whereIn('id', $specialOfferProductIds);
            }
        }

        if (isset($parameters['categories'])) {
            $parameters['category_ids'] = [];
            foreach ($parameters['categories'] as $slug) {
                $parameters['category_ids'] = Category::query()->where('slug', $slug)->pluck('id')->toArray();
            }
            if (count($parameters['category_ids']) == 0) {
                unset($parameters['category_ids']);
            }
        }

        if (isset($parameters['category_ids'])) {
            $categoryIds = array_map(fn($category_id) => (int)$category_id, $parameters['category_ids']);

            $categoryIds = array_unique(array_merge($categoryIds, $this->getAllChildren($categoryIds[0])));

            $query->whereIn('categories.id', $categoryIds);
        }

        if (isset($parameters['attributes'])) {
            $attributeValues = AttributeValue::query()->whereIn('id', $parameters['attributes'])->get()->groupBy('attribute_id');

            foreach ($attributeValues as $attributeValue) {
                $query->where(function ($query) use ($attributeValue) {
                    foreach ($attributeValue as $item) {
                        $query->orWhere('attributes.values.id', (int)$item->id);
                    }
                });
            }
        }

        if (isset($parameters['is_discounted']) && $parameters['is_discounted']) {
            $query
                ->whereRaw(['$expr' => ['$gt' => ['$price_original', '$price_promoted']]])
                ->whereNotNull('price_promoted')
                ->where('price_promoted', '!=', 0);
        }

        if (isset($parameters['store_ids'])) {
            if (!is_array($parameters['store_ids'])) {
                $parameters['store_ids'] = array($parameters['store_ids']);
            }
            $storeIds = array_map(fn($store_id) => (int)$store_id, $parameters['store_ids']);

            $query->whereIn('store_id', $storeIds);
        }

        $brandIds = [];

        if (isset($parameters['brand_id'])) {
            $brandIds = array_merge($brandIds, [$parameters['brand_id']]);
        }

        if (isset($parameters['brand_ids'])) {
            $brandIds = array_merge($brandIds, array_map(fn($brand_id) => (int)$brand_id, $parameters['brand_ids']));

        }
        if (count($brandIds) > 0) {
            $query->whereIn('brand_id', $brandIds);
        }

        if (isset($parameters['price_range_up'])) {
            $query->where(function ($query) use ($parameters) {
                $query->where(function ($query) use ($parameters) {
                    $query->where('price_original', '<', (int)$parameters['price_range_up'])
                        ->where('price_promoted', 0);
                });
                $query->orWhere(function ($query) use ($parameters) {
                    $query->where('price_promoted', '<', (int)$parameters['price_range_up'])
                        ->where('price_promoted', '!=', 0);
                });
            });
        }

        if (isset($parameters['price_range_down'])) {
            $query->where(function ($query) use ($parameters) {
                $query->where(function ($query) use ($parameters) {
                    $query->where('price_original', '>', (int)$parameters['price_range_down'])
                        ->where('price_promoted', 0);
                });
                $query->orWhere(function ($query) use ($parameters) {
                    $query->where('price_promoted', '>', (int)$parameters['price_range_down'])
                        ->where('price_promoted', '!=', 0);
                });
            });
        }

        if (isset($parameters['is_in_stock']) && $parameters['is_in_stock']) {
            $query->where('is_in_stock', (int)$parameters['is_in_stock']);
        }

        $query->where('status', FlatProduct::STATUS_ACTIVE);


        $query->where('visibility', FlatProduct::VISIBILITY_VISIBLE);


        if (isset($parameters['best_seller'])) {
            $bestSellerProductIds = OrderedProduct::query()->orderByDesc('ordered_quantity')->pluck('product_id');

            $query->whereIn('id', $bestSellerProductIds);
        }

        $sortBy = $parameters['sort_by'] ?? null;
        if ($sortBy == 'expensive') {
            $query->orderBy('price');
        } elseif ($sortBy == 'cheapest') {
            $query->orderByDesc('price');
        } elseif ($sortBy == 'discount') {
            $query->orderByDesc('discounted_percent');
        } elseif ($sortBy == 'newest') {
            $query->orderByDesc('created_at');
        } elseif ($sortBy == 'seller') {
            $query->orderByDesc('sell_count');
        } elseif ($sortBy == 'popular') {
            $query->orderByDesc('view_count');
        }

        $query->orderByDesc('is_in_stock');

        return $query->paginate($parameters['per_page'] ?? $this->model->getPerPage(), $columns);

    }

    protected function export(Builder $query, array $parameters = [], array $columns = ['*']): Collection|LengthAwarePaginator|array
    {
        if (isset($parameters['export_type']) && $parameters['export_type'] == 'collection') {
            $products = $query->get($columns);
            if (isset($parameters['group_by'])) {
                $grouped = [];
                foreach ($products as $product) {
                    foreach ($product->categories as $category) {
                        $grouped[$category['title']][$product->id] = $product;
                    }
                }
                return collect($grouped);
            }
            return $products;
        } else
            return $query->paginate($parameters['per_page'] ?? $this->model->getPerPage(), $columns);

    }

    public function filter(array $queries = []): array
    {
        $models = $this->model->query();

        if (isset($queries['status'])) {
            $models->where('status', (int)$queries['status']);
        } else {
            $models->where('status', FlatProduct::STATUS_ACTIVE);
        }

        if (isset($queries['visibility']) && !$queries['visibility']) {
            $models->where('visibility', $queries['visibility']);
        } else {
            $models->where('visibility', FlatProduct::VISIBILITY_VISIBLE);
        }

        if (isset($queries['categories'])) {
            $queries['category_ids'] = [];
            foreach ($queries['categories'] as $slug) {
                $queries['category_ids'] = Category::query()->where('slug', $slug)->pluck('id')->toArray();
            }
            if (count($queries['category_ids']) == 0) {
                unset($queries['category_ids']);
            }
        }

        if (isset($queries['category_ids'])) {
            $categoryIds = array_map(fn($category_id) => (int)$category_id, $queries['category_ids']);

            $categoryIds = $this->getAllChildren($categoryIds[0]) ? $this->getAllChildren($categoryIds[0]) : $categoryIds;

            $models->whereIn('categories.id', $categoryIds);
        }

        if (isset($queries['brand_ids'])) {
            $brandIds = array_map(fn($brand_id) => (int)$brand_id, $queries['brand_ids']);

            $models->whereIn('brand_id', $brandIds);
        }

        if (isset($queries['store_ids'])) {
            $storeIds = array_map(fn($store_id) => (int)$store_id, $queries['store_ids']);

            $models->whereIn('store_id', $storeIds);
        }

        $foundCategories = [];

        if (isset($queries['category_ids'])) {
            $categoriesQuery = clone $models;
            $categories = $categoriesQuery
                ->distinct()
                ->get(['categories'])->toArray();

            $children = Arr::pluck($categories, 'id');

            $diff = array_diff($categoryIds, $children);

            $allCategories = Category::query()
                ->whereIn('id', $categoryIds)
                ->get([
                    'id',
                    'parent_id',
                ])
                ->toArray();

            $this->addChildrenParents($children, $allCategories, $diff);

            $foundCategories = array_unique(array_merge($this->getAllParents($queries['category_ids'][0]), array_unique($children)));
        }

        $brands = collect();

        if (isset($queries['category_ids'])) {
            $brandsQuery = clone $models;
            $brands = $brandsQuery->groupBy('brand_id')->get(['brand']);
        }

        $priceQuery = clone $models;
        $price_max = (int)$priceQuery->max('price_original');
        $price_min = (int)$priceQuery->min('price_original');

        $attributes = $this->getFilterAttributes($models, $queries);

        $categories = Category::query()
            ->orderBy('position')
            ->get([
                'id',
                'title',
                'parent_id',
                'slug',
                'icon',
                'image',
                'color',
                'status',
                'level',
                'position',
                'en_name',
                'visible_in_menu',
            ]);

        $categoryIds = array_map(fn($category_id) => (int)$category_id, $queries['category_ids'] ?? []);

        $nestedCategories = $this->nestedCategories($categories, Category::ROOT, $foundCategories, isset($queries['in_menu']) && $queries['in_menu'] == 1);

        if (isset($queries['category_ids'])) {

            $categoriesBackup = clone $categories;
            if (!is_null((int)$categoryIds[0] ?? null))
                $nestedCategories = $this->removeAdditionalBranches($nestedCategories, (int)$categoryIds[0], $categoriesBackup);
        }

        if (!isset($queries['category_ids']) || $queries['category_ids'][0] == 2) {
            $nestedCategories = Category::query()
                ->where('status', 1)
                ->where('visible_in_menu', 1)
                ->where('level', 0)
                ->orderBy('position')->get([
                    'id',
                    'title',
                    'parent_id',
                    'slug',
                    'icon',
                    'image',
                    'color',
                    'status',
                    'level',
                    'position',
                    'en_name',
                    'visible_in_menu',
                ]);
        }

        if (!isset($queries['category_ids'])) {
            $brands = $models->groupBy('brand_id')->get(['brand_id', 'brand.name', 'brand_thumbnail']);
        }

        return [
            'brands'     => $brands,
            'categories' => $nestedCategories,
            'attributes' => $attributes,
            'price'      => [
                'price_max' => $price_max,
                'price_min' => $price_min,
            ]
        ];
    }

    public function leach(array $queries = []): array
    {
        $models = $this->model->query();

        $models->where('status', FlatProduct::STATUS_ACTIVE);

        $models->where('visibility', FlatProduct::VISIBILITY_VISIBLE);

        if (isset($queries['categories'])) {
            $categories = Category::query()
                ->whereIn('slug', (array)$queries['categories'])
                ->pluck('id')
                ->toArray();

            $queries['category_ids'] = array_merge($queries['category_ids'], $categories);
        }

        $parents = [];
        if (isset($queries['category_ids'])) {

            $parents = Category::query()
                ->whereIn('slug', (array)$queries['category_ids'])
                ->get()
                ->toArray();


            $categoryIds = (array)$queries['category_ids'];
            foreach ($queries['category_ids'] as $category_id) {
                $categoryIds = array_merge($categoryIds, $this->getAllChildren($category_id));
            }
            $categoryIds = array_map(fn($category_id) => (int)$category_id, $queries['category_ids']);

            $models->whereIn('categories.id', $categoryIds);
        }

        if (isset($queries['brand_ids'])) {
            $brandIds = array_map(fn($brand_id) => (int)$brand_id, $queries['brand_ids']);

            $models->whereIn('brand_id', $brandIds);
        }

        if (isset($queries['store_ids'])) {
            $storeIds = array_map(fn($store_id) => (int)$store_id, $queries['store_ids']);

            $models->whereIn('store_id', $storeIds);
        }

        if (isset($parameters['attributes'])) {

            foreach ((array)$parameters['attributes'] as $attribute) {
                $models->where('attributes.values.id', (int)$attribute);
            }
        }

        $brands = collect();

        if (isset($queries['category_ids'])) {
            $brands = (clone $models)->groupBy('brand_id')->get(['brand'])->toArray();

            $brands = array_map(fn($brand) => $brand['brand'], $brands);
        }

        $priceQuery = clone $models;
        $price_max = (int)$priceQuery->max('price_original');
        $price_min = (int)$priceQuery->min('price_original');

        $attributes = $this->getFilterAttributes($models, $queries);

        $categories = Category::query()
            ->whereIn('id', (isset($queries['category_ids']) && count($queries['category_ids'])) ? $queries['category_ids'] : [Category::ROOT])
            ->orderBy('position')
            ->get(['id', 'parent_id']);

        $cats = Category::query()
            ->whereIn('parent_id', $categories->pluck('id'))
            ->orderBy('position')
            ->get();

        if ($cats->count() == 0) {
            $cats = Category::query()
                ->whereIn('parent_id', $categories->pluck('parent_id'))
                ->orderBy('position')
                ->get();
        }


        return [
            'brands'     => $brands,
            'parents'    => $parents,
            'categories' => $cats,
            'attributes' => $attributes,
            'price'      => [
                'price_max' => $price_max,
                'price_min' => $price_min,
            ]
        ];
    }

    private
    function getFilterAttributes(Builder $models, array $queries): array
    {
        $attributeList = [];

        if (isset($queries['category_ids'])) {
            $productAttributes = $models->get(['attributes'])->pluck('attributes')->toArray();
            foreach ($productAttributes as $productAttribute) {
                foreach ($productAttribute as $attribute) {
                    if ($attribute['filterable'] ?? null) {
                        $attributeList[$attribute['id']]['title'] = $attribute['title'];
                        if (isset($attributeList[$attribute['id']]['values'])) {
                            foreach ($attribute['values'] as $value) {
                                if (!in_array($value['id'], array_column($attributeList[$attribute['id']]['values'], 'id'))) {
                                    $attributeList[$attribute['id']]['values'][] = $value;
                                }
                            }
                        } else {
                            $attributeList[$attribute['id']]['values'] = $attribute['values'];
                        }
                    }
                }
            }
            $attributeList = array_values($attributeList);
        }

        return $attributeList;
    }

    public
    function listBySkuAndStore(array $items): Collection
    {
        $allProducts = collect();
        foreach ($items as $item) {
            $product = FlatProduct::query()
                ->where('sku', $item['sku'])
                ->where('store_id', $item['store_id'])
                ->where('merchant_id', $item['merchant_id'])
                ->first();

            if ($product)
                $allProducts->push($product);
        }
        return $allProducts;
    }

    public
    function listByIdAndStore(array $items): Collection
    {
        $storeId = 1;
        $allProducts = collect();
        foreach ($items as $item) {
            $product = FlatProduct::query()
                ->where('id', $item)
                ->where('store_id', $storeId)
                ->first();

            if ($product)
                $allProducts->push($product);
        }
        return $allProducts;
    }

    public
    function findBySku(array $parameter): ?Model
    {
        return FlatProduct::query()
            ->where('sku', (string)$parameter['sku'])
            ->where('store_id', (int)$parameter['store_id'])
            ->first();
    }

    public
    function syncInventory(array $parameters): void
    {
        \Log::error('syncInventory >>>> ' . json_encode($parameters));
        foreach ($parameters as $parameter) {
            $this->saveFlatProduct($parameter);
        }
    }

    public
    function saveFlatProduct(array $parameter): void
    {
        /** @var FlatProduct $flatProduct */
        $flatProduct = $this->findBySku($parameter);
        if ($flatProduct) {
            $this->modifyStock($parameter, $flatProduct);
        } else {
            $this->make($parameter);
        }
    }

    public
    function modifyStock(array $parameter, FlatProduct $flatProduct): void
    {
        /** @var Product $product */
        $product = Product::query()->where('sku', $parameter['sku'])->first();

        $flatProduct->fill($this->mapper($product));

        $flatProduct->discounted_percent = 0;
        if (array_key_exists('price_original', $parameter)) {
            $flatProduct->price_original = $flatProduct->price = $parameter['price_original'];
        }
        if (array_key_exists('price_promoted', $parameter)) {
            $flatProduct->price_promoted = $flatProduct->price = $parameter['price_promoted'];
            $flatProduct->discounted_percent = ($flatProduct->price_original != 0 && $flatProduct->price_promoted) ? round(($flatProduct->price_original - $flatProduct->price_promoted) / $flatProduct->price_original * 100) : 0;
        }
        if (array_key_exists('status', $parameter)) {
            $flatProduct->is_in_stock = (bool)$parameter['status'];
        }
        if (array_key_exists('quantity', $parameter)) {
            $flatProduct->quantity = $parameter['quantity'];
        }
        if (array_key_exists('batch_id', $parameter)) {
            $flatProduct->batch_id = $parameter['batch_id'];
        }
        if (array_key_exists('store_id', $parameter)) {
            $flatProduct->store_id = $parameter['store_id'];
        }
        if (array_key_exists('merchant_id', $parameter)) {
            $flatProduct->merchant_id = $parameter['merchant_id'];
        }
        $flatProduct->save();
    }

    public
    function make(array $parameter, array $only = []): void
    {
        /** @var Product $product */
        $product = Product::query()->where('sku', $parameter['sku'])->first();
        if ($product == null) {
            return;
        }

        $this->modifyStock($parameter, new FlatProduct($this->mapper($product)));
    }

    public
    function mapper(Product $product, array $only = []): array
    {
        $product = $product->load(['productValues.attribute', 'productValues.attributeValue']);

        $bundles = $product->bundles->map(fn($child) => [
            'id'       => $child?->id,
            'quantity' => $child?->pivot->quantity,
            'price'    => $child?->pivot->price,
        ])->all();

        $attributes = [];
        /** @var ProductValue $productcValue */
        foreach ($product->productValues as $productValue) {
            $value = [
                'id'    => $productValue->attributeValue->id,
                'name'  => $productValue->attributeValue->name,
                'value' => $productValue->attributeValue->value,
                'image' => $productValue->attributeValue->image,
            ];
            /** @var Attribute $attribute */
            $attribute = $productValue->attribute;

            if (!isset($attributes[$attribute->slug])) {
                $attributes[$attribute->slug] = [
                    'id'         => $attribute->id,
                    'title'      => $attribute->title,
                    'slug'       => $attribute->slug,
                    'type'       => $attribute->type,
                    'searchable' => $attribute->searchable,
                    'filterable' => $attribute->filterable,
                    'comparable' => $attribute->comparable,
                ];
            }
            $attributes[$attribute->slug]['values'][] = $value;
        }
        $attributes = array_values($attributes);

        $gallery = $product->images->map(fn($image) => $image->only(['url', 'is_thumbnail', 'position']))->all();
        $categories = $product->categories->map(fn($category) => $category->only(['id', 'title', 'slug', 'path']))->all();
        $fields = [
            'type'             => $product->type,
            'sku'              => $product->sku,
            'id'               => $product->id,
            'public_id'        => $product->public_id,
            'name'             => $product->name,
            'description'      => $product->description,
            'status'           => $product->status,
            'gallery'          => $gallery,
            'brand'            => $product->brand->toArray(),
            'brand_id'         => $product->brand_id,
            'url_key'          => $product->url_key,
            'tax_class'        => $product->tax_class,
            'visibility'       => $product->visibility,
            'min_in_cart'      => $product->min_in_cart,
            'max_in_cart'      => $product->max_in_cart,
            'barcode'          => $product->barcode ?? null,
            'dimensions'       => $product->dimensions ?? null,
            'meta_title'       => $product->meta_title ?? null,
            'meta_keyword'     => $product->meta_keyword ?? null,
            'meta_description' => $product->meta_description ?? null,
            'categories'       => $categories,
            'master_id'        => $product->master_id,
            'configurable'     => $product->configurable,
            'bundles'          => $bundles,
            'view_count'       => 0,
            'attributes'       => $attributes,
            'created_at'       => $product->created_at,
            'updated_at'       => $product->updated_at,
        ];
        if (count($only)) {
            $fields = Arr::only($fields, $only);
        }
        return $fields;
    }

    public
    function showBySku(string $sku): ?Collection
    {
        $flatProducts = FlatProduct::query()
            ->raw(function ($collection) use ($sku) {
                return $collection->aggregate([
                    [
                        '$match' => [
                            'sku' => $sku
                        ]
                    ],
                    [
                        '$addFields' => [
                            'price' => [
                                '$cond' => [
                                    'if'   => [
                                        '$and' => [
                                            '$eq' => ['$price_promoted', null],
                                            '$eq' => ['$price_promoted', 0],
                                        ],
                                    ],
                                    'then' => '$price_original',
                                    'else' => '$price_promoted']]
                        ]
                    ],
                    [
                        '$sort' => ['price' => 1]
                    ],
                ]);
            });

        $objects = json_decode(json_encode($flatProducts->toArray(), true));
        $array = json_decode(json_encode($objects), true);
        $productArray = [];
        foreach ($array as $item) {
            $productArray[] = new FlatProduct($item);
        }

        $collection = collect($productArray);
        FlatProduct::query()->where('sku', $sku)->increment('view_count');

        return $collection;
    }

    public
    function massCreationFlatCategory(Collection $flatCategories): void
    {
        $array = [];
        foreach ($flatCategories as $flatCategory) {
            $array [] = [
                'id'        => $flatCategory->id,
                'title'     => $flatCategory->title,
                'parent_id' => $flatCategory->parent_id,
                'image'     => $flatCategory->image,
                'icon'      => $flatCategory->icon,
                'status'    => 1,
            ];
        }
        FlatCategory::query()->insert($array);
    }

    private
    function buildNestedCategories($tree, $root, $foundCategories = [], $inMenu = false): array
    {
        $return = array();

        foreach ($tree as $key => $item) {
            if ($item->parent_id == $root) {
                if ((!$inMenu || $item->visible_in_menu) && (in_array($item->id, $foundCategories) || empty($foundCategories))) {
                    $return[] = array_merge($item->toArray(),
                        [
                            'children' => $this->buildNestedCategories($tree, $item->id, $foundCategories, $inMenu)
                        ]
                    );
                }
            }
        }

        return $return;
    }

    public
    function nestedCategories($tree, $root, $foundCategories = [], $inMenu = false, $visibleBranchId = null): ?array
    {
        $return = $this->buildNestedCategories($tree, $root, $foundCategories, $inMenu);

        foreach ($return as $key => $item) {
            if ($inMenu && $item['visible_in_menu'] == "0") {
                unset($return[$key]);
            }
        }

        return array_values($return);
    }

    private
    function removeAdditionalBranches($tree, $visibleBranchId, Collection $backupTree, bool $isFound = false): array
    {
        $return = [];
        foreach ($tree as $key => $item) {
            $foundNow = false;

            if ($item['id'] == $visibleBranchId | $isFound)
                $foundNow = true;

            if (count($item['children']) > 0) {
                $returnItem = $this->removeAdditionalBranches($item['children'], $visibleBranchId, $backupTree, $foundNow);
                if (count($returnItem) > 0)
                    $return[] = array_merge(Arr::except($item, 'children'), ['children' => $returnItem]);
            } else {
                if ($foundNow) {
                    $return = array_merge($return, [$item]);

                    if ($item['id'] == $visibleBranchId) {
                        $return = array_merge($return,
                            $backupTree->filter(function ($value, $key) use ($item) {
                                return $value->parent_id == $item['parent_id'] && $value->id != $item['id'];
                            })->sortBy('position')->toArray()
                        );
                        $return = array_values(collect($return)->sortBy('position')->toArray());
                    }
                }
            }
        }

        return $return;
    }

    public
    function getAllChildren(int $categoryId): array
    {
        $categories = Category::query()
            ->where('status', Category::ACTIVE)
            ->orderBy('position')
            ->get([
                'id',
                'parent_id',
                'status',
                'level',
                'icon',
                'position',
                'visible_in_menu',
            ]);
        $nestedCategories = $this->nestedCategories($categories, $categoryId);

        for ($index = 0; $index < count($nestedCategories); $index++) {
            if (isset($nestedCategories[$index]['children']) && count($nestedCategories[$index]['children']) > 0) {
                foreach ($nestedCategories[$index]['children'] as $child) {
                    $nestedCategories[] = $child;
                }
            }
            $nestedCategories[$index] = $nestedCategories[$index]['id'];
        }

        return $nestedCategories;
    }

    private
    function getAllParents(int $categoryId): array
    {

        $categories = Category::query()
            ->orderBy('position')
            ->get([
                'id',
                'parent_id',
                'status',
                'level',
                'icon',
                'position',
                'visible_in_menu',
            ]);

        $currentId = $categoryId;

        $cats = collect();
        while ($currentId > 2) {
            $currentItem = $categories->where('id', $currentId)->first();
            $cats->push($currentItem);
            $currentId = $currentItem->parent_id;
        }
        return $cats->pluck('id')->toArray() ?? [];
    }

    private
    function addChildrenParents(&$children, &$allCategories, &$diff)
    {

        foreach ($diff as $index => $item) {
            foreach ($allCategories as $category) {
                if ($item == $category['parent_id']) {
                    $children[] = $item;
                    unset($diff[$index]);
                    $this->addChildrenParents($children, $allCategories, $diff);
                }
            }
        }
    }

    public
    function fetch(array $parameters): FlatProduct
    {
        /** @var FlatProduct $flatProduct */
        $flatProduct = $this->model->query()
            ->where('sku', $parameters['sku'])
            ->where('store_id', (int)$parameters['store_id'])
            ->where('merchant_id', (int)$parameters['merchant_id'])
            ->where('master_id', null)
            ->firstOrFail();

        return $flatProduct;
    }

    public
    function search($parameters): LengthAwarePaginator
    {
        Search::query()->updateOrCreate([
            'user_id' => Authenticate::id(),
            'phrase'  => $parameters['query']
        ]);

        return FlatProduct::search($parameters['query'])
            ->where('store_id', $parameters['store_id'])
            ->where('visibility', 1)
            ->where('status', 1)
            ->paginate();
    }

    public
    function recentSearches($parameters): Collection
    {
        return Search::query()
            ->where('user_id', Authenticate::id())
            ->latest()
            ->take(5)
            ->get(['phrase'])
            ->pluck('phrase');
    }

    public
    function popularSearches(): array
    {
        $results = Search::query()
            ->raw(function ($collection) {
                return $collection->aggregate([
                    [
                        '$sortByCount' => '$phrase'
                    ],
                    [
                        '$limit' => 5
                    ]
                ]);
            });

        return array_column($results->toArray(), '_id');
    }

    public
    function createMenuByAttribute(): array
    {
        $attributeValues = Attribute::query()
            ->join('attribute_values', 'attribute_values.attribute_id', 'attributes.id')
            ->where('attributes.slug', 'type')
            ->selectRaw('attribute_values.id as attribute_values_id, attribute_values.value as attribute_values_value');

        $categoryParent = Category::query();

        $categoryAttributesValues = Category::query()
            ->join('product_category', 'product_category.category_id', 'categories.id')
            ->join('product_values', 'product_values.product_id', 'product_category.product_id')
            ->joinSub($attributeValues, 'attribute_value', 'product_values.attribute_value_id', 'attribute_value.attribute_values_id')
            ->joinSub($categoryParent, 'category_parent', 'category_parent.id', 'categories.parent_id')
            ->selectRaw('attribute_value.* , categories.id as cat_id , categories.title as cat_title, category_parent.id as cat_parent_id, category_parent.title as cat_parent_title')
            ->get();

        $attributes = $attributeValues->get()->map(fn($item) => ['id' => $item['attribute_values_id'], 'value' => $item['attribute_values_value']])->all();
        foreach ($attributes as $key => $attribute) {
            $categories = (clone $categoryAttributesValues)
                ->where('attribute_values_id', $attribute['id'])
                ->unique('cat_parent_id')
                ->map(fn($item) => ['id' => $item['cat_parent_id'], 'title' => $item['cat_parent_title']])
                ->all();

            foreach ($categories as $child => $category) {
                $categories[$child]['children'] =  (clone $categoryAttributesValues)
                    ->where('cat_parent_id', $category['id'])
                    ->where('attribute_values_id', $attribute['id'])
                    ->map(fn($item) => ['id' => $item['cat_id'], 'title' => $item['cat_title']])
                    ->unique('cat_id')
                    ->values()
                    ->all();
            }
            $attributes[$key]['categories'] = array_values($categories);
        }

        Cache::forever('mega_menu', $attributes);

        return $attributes;
    }

    public
    function menuByAttribute(): array
    {
        return Cache::rememberForever('mega_menu', fn() => $this->createMenuByAttribute());
    }
}
