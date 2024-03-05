<?php

namespace App\Services\ProductService\V1\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\EmbedsOne;

/**
 * @property int $store_id
 * @property int $merchant_id
 * @property int $id
 * @property int $public_id
 * @property int $type
 * @property string $name
 * @property string $sku
 * @property int $price_original
 * @property int $price_promoted
 * @property int $price
 * @property int $discounted_percent
 * @property int $quantity
 * @property int $max_in_cart
 * @property int $min_in_cart
 * @property string $description
 * @property int $status
 * @property int $is_in_stock
 * @property array $gallery
 * @property array $brand
 * @property int $batch_id
 * @property int $brand_id
 * @property int $brand_thumbnail
 * @property string $url_key
 * @property array $categories
 * @property int $master_id
 * @property array $master
 * @property int $bundle_products
 * @property int $related_products
 * @property int $view_count
 * @property array $attributes
 * @property int $level
 * @property int $tax_class
 * @property int $visibility
 * @property string $barcode
 * @property int $color
 * @property int $dimensions
 * @property string $meta_title
 * @property string $meta_keyword
 * @property string $meta_description
 * @property null|FlatProduct $configurable
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class FlatProduct extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Searchable;

    protected $connection = 'mongodb';

    protected $perPage = 20;

    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;
    public const STATUS_UNAVAILABLE = 2;

    public const VISIBILITY_INVISIBLE = 0;
    public const VISIBILITY_VISIBLE = 1;

    protected $fillable = [

        'store_id',
        'merchant_id',
        'id',
        'public_id',
        'type',
        'name',
        'sku',
        'price_original',
        'price_promoted',
        'price',
        'discounted_percent',
        'quantity',
        'min_in_cart',
        'max_in_cart',
        'description',
        'status',
        'is_in_stock',
        'gallery',
        'brand',
        'batch_id',
        'brand_id',
        'brand_thumbnail',
        'url_key',
        'categories',
        'master_id',
        'configurable',
        'bundle_products',
        'related_products',
        'view_count',
        'sell_count',
        'attributes',
        'level',
        'tax_class',
        'visibility',
        'barcode',
        'color',
        'dimensions',
        'meta_title',
        'meta_keyword',
        'meta_description',
    ];

    public function qualifyColumn($column)
    {
        return $column;
    }

    public function toSearchableArray(): array
    {
        return [
            'name'       => $this->name,
            'sku'        => $this->sku,
            'visibility' => $this->visibility,
            'status'     => $this->status,
            'store_id'   => $this->store_id,
        ];
    }

    public function brand(): EmbedsOne
    {
        return $this->embedsOne(FlatBrand::class);
    }

    public function configurable(): EmbedsOne
    {
        return $this->embedsOne(FlatProduct::class);
    }
}
