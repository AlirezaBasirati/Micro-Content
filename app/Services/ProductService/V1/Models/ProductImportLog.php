<?php

namespace App\Services\ProductService\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property int $status
 */
class ProductImportLog extends Model
{
    use HasFactory;

    const STATUS_NEW = 0;
    const STATUS_SUCCESS = 1;

    protected $fillable = [
        'actor_id',
        'file_path',
        'status',
    ];
}
