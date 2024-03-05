<?php

namespace App\Services\ProductService\V1\Models;

use App\Services\CampaignService\V1\Models\Campaign;
use App\Services\ProductService\V1\Enumerations\Product\Type;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Laravel\Scout\Searchable;

/**
 * @property string $name
 * @property string $sku
 * @property int $visibility
 * @property int $status
 * @property integer $id
 * @property string $type
 * @property string $description
 * @property integer $brand_id
 * @property integer $max_in_cart
 * @property integer $min_in_cart
 * @property string $url_key
 * @property string $tax_class
 * @property string $barcode
 * @property string $dimensions
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property Brand $brand
 * @property Collection<ProductCategory> $categories
 * @property Collection<ProductImage> $images
 * @property Collection<ProductValue> $productValues
 * @property Product $master
 * @property Collection<Product> $subProducts
 * @property Collection<Product> $bundles
 * @property Collection<Product> $relation
 * @property Collection<Widget> $widgets
 * @property Collection<Campaign> $campaigns
 * @property string $public_id
 * @property string $master_id
 * @property Product $configurable
 */
class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function searchableAs(): string
    {
        return 'products_index';
    }

    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;
    public const STATUS_UNAVAILABLE = 2;

    public const VISIBILITY_INVISIBLE = 0;
    public const VISIBILITY_VISIBLE = 1;

    protected $fillable = [
        'id',
        'public_id',
        'master_id',
        'type',
        'name',
        'sku',
        'description',
        'status',
        'brand_id',
        'url_key',
        'tax_class',
        'visibility',
        'barcode',
        'weight',
        'max_in_cart',
        'min_in_cart',
        'dimensions',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'master_id'
    ];

    protected $casts = [
        'type' => Type::class
    ];

    /**
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    /**
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * @return HasMany
     */
    public function productValues(): HasMany
    {
        return $this->hasMany(ProductValue::class);
    }

    /**
     * @return BelongsTo
     */
    public function configurable(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'master_id');
    }

    /**
     * @return HasMany
     */
    public function subProducts(): HasMany
    {
        return $this->hasMany(Product::class, 'master_id');
    }


    /**
     * @return BelongsToMany
     */
    public function bundles(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'bundle_products', 'product_id', 'child_id')->withPivot('quantity', 'price');
    }

    /**
     * @return BelongsToMany
     */
    public function related(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'related_products', 'product_id', 'children');
    }

    /**
     * @return BelongsToMany
     */
    public function widgets(): BelongsToMany
    {
        return $this->belongsToMany(Widget::class, 'widget_product');
    }

    /**
     * @return BelongsToMany
     */
    public function campaigns(): BelongsToMany
    {
        return $this->belongsToMany(Campaign::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(Product::class, 'master_id');
    }
}
