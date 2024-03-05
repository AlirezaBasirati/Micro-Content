<?php

namespace App\Services\ProductService\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeAttributeSet extends Model
{
    use HasFactory;

    protected $fillable = [
        'attribute_id',
        'attribute_set_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
