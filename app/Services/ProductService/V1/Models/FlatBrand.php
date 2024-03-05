<?php

namespace App\Services\ProductService\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use MongoDB\Laravel\Eloquent\Model;

class FlatBrand extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mongodb';

    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;

    protected $fillable = [
        'id',
        'name',
        'description',
        'status',
    ];


    public function flatProducts(): HasMany
    {
        return $this->hasMany(FlatProduct::class, 'product_brand_id');
    }
}
