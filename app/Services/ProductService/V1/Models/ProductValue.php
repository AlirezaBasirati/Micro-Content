<?php

namespace App\Services\ProductService\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductValue extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'attribute_value_id',
        'product_id',
        'attribute_id',
    ];

    public function attributeValue(): belongsTo
    {
        return $this->belongsTo(AttributeValue::class);
    }

    public function product(): belongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function attribute(): belongsTo
    {
        return $this->belongsTo(Attribute::class);
    }
}
