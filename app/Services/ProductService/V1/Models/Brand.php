<?php

namespace App\Services\ProductService\V1\Models;

use App\Services\ProductService\V1\Database\Factories\BrandFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Brand extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Searchable;

    public function searchableAs(): string
    {
        return 'brands_index';
    }

    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;

    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'manufactured_in',
        'en_name',
        'image',
        'thumbnail',
        'is_featured',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    protected static function newFactory(): BrandFactory
    {
        return BrandFactory::new();
    }
}
