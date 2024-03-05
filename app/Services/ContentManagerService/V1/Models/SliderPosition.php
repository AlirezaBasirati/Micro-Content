<?php

namespace App\Services\ContentManagerService\V1\Models;

use App\Services\ContentManagerService\V1\Database\Factories\SliderPositionFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property Collection<Slider> $sliders
 */
class SliderPosition extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
    ];

    public function sliders(): HasMany
    {
        return $this->hasMany(Slider::class,'position_id');
    }

    protected static function newFactory(): SliderPositionFactory
    {
        return SliderPositionFactory::new();
    }
}
