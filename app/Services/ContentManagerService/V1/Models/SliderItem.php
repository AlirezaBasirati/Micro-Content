<?php

namespace App\Services\ContentManagerService\V1\Models;

use App\Services\ContentManagerService\V1\Database\Factories\SliderItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SliderItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    protected $fillable = [
        'title',
        'url',
        'status',
        'slider_id',
        'image_url',
    ];

    protected static function newFactory(): SliderItemFactory
    {
        return SliderItemFactory::new();
    }
}
