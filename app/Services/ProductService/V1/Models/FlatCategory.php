<?php

namespace App\Services\ProductService\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use MongoDB\Laravel\Eloquent\Model;

class FlatCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mongodb';

    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;

    protected $fillable = [
        'id',
        'title',
        'parent_id',
        'image',
        'icon',
        'status',
    ];


    public function flatProducts(): HasMany
    {
        return $this->hasMany(FlatProduct::class);
    }
}
