<?php

namespace App\Services\ProductService\V1\Models;

use App\Services\ProductService\V1\Database\Factories\AttributeFactory;
use App\Services\ProductService\V1\Enumerations\Attribute\Type;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $type
 * @property int $searchable
 * @property int $filterable
 * @property int $comparable
 * @property int $attribute_group_id
 * @property int $visible
 * @property int $status
 */
class Attribute extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;

    protected $fillable = [
        'id',
        'title',
        'slug',
        'type',
        'searchable',
        'filterable',
        'comparable',
        'attribute_group_id',
        'visible',
        'status',
    ];

    protected $casts = [
        'type' => Type::class,
    ];

    public function attributeSets(): BelongsToMany
    {
        return $this->belongsToMany(AttributeSet::class, 'attribute_set');
    }

    public function attributeValues(): HasMany
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function attributeGroup(): belongsTo
    {
        return $this->belongsTo(AttributeGroup::class);
    }

    protected static function newFactory(): AttributeFactory
    {
        return AttributeFactory::new();
    }
}
