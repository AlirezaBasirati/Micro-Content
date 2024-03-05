<?php

namespace App\Services\SpecialOfferService\V1\Models;

use App\Services\ProductService\V1\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property Collection $products
 * @property string $name
 * @property string $slug
 * @method static available()
 */
class SpecialOffer extends Model
{
    use HasFactory;
    use SoftDeletes;

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    protected $fillable = [
        'id',
        'product_id',
        'available_from',
        'available_to',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where(function ($query) {
            $query->where('available_from', '<=', now()->format('Y-m-d H:i:s'));
            $query->where('available_to', '>=', now()->format('Y-m-d H:i:s'));
        });
    }
}
