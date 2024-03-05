<?php

namespace App\Services\ProductService\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderedProduct extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'product_id',
        'orders',
        'ordered_quantity',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
