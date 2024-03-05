<?php

namespace App\Services\ProductService\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed $id
 * @property mixed $attribute_id
 * @property mixed $value
 * @property mixed $image
 * @property mixed $name
 */
class AttributeValue extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'attribute_id',
        'value',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array'
    ];

    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    public function productValue(): HasOne
    {
        return $this->hasOne(ProductValue::class);
    }

    public function getImageAttribute()
    {
        return $this->meta['image'] ?? null;
    }

    public function getNameAttribute()
    {
        return $this->meta['name'] ?? null;
    }
}
