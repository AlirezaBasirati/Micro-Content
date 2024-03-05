<?php

namespace App\Services\ProductService\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use MongoDB\Laravel\Eloquent\Model;

class FlatCategoryBrand extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mongodb';

    protected $perPage = 20;

    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;

    protected $fillable = [
        'id',
        'category_id',
        'brands',
    ];
}
