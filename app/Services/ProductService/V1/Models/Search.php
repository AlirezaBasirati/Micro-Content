<?php

namespace App\Services\ProductService\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Eloquent\SoftDeletes;

class Search extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = 'mongodb';

    protected $fillable = [
        'id',
        'user_id',
        'phrase',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
