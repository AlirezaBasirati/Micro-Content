<?php

namespace App\Services\ProductService\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'product_category';

    protected $fillable = [
        'product_id',
        'category_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
