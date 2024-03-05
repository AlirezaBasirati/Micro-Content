<?php

namespace App\Services\ContentManagerService\V1\Models;

use App\Services\ContentManagerService\V1\Database\Factories\SliderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    protected $fillable = [
        'title',
        'type',
        'position_id',
        'status',
        'height',
        'width',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(SliderItem::class);
    }

    protected static function newFactory(): SliderFactory
    {
        return SliderFactory::new();
    }
}
