<?php

namespace App\Services\ProductService\V1\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Laravel\Scout\Searchable;

/**
 * @property Category $parent
 * @property int $parent_id
 * @property int $id
 * @property string $title
 * @property string $image
 * @property string $icon
 * @property string $slug
 * @property string $description
 * @property int $status
 * @property array $path
 * @property integer $level
 * @property integer $position
 * @property Collection $products
 * @property Collection $children
 */
class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Sluggable;
    use Searchable;

    const IN_ACTIVE = 0;
    const ACTIVE = 1;
    public const ROOT = 1;

    protected $perPage = 10;

    public function searchableAs(): string
    {
        return 'categories_index';
    }

    protected $casts = [
        'path' => 'array',
    ];

    protected $fillable = [
        'id',
        'title',
        'parent_id',
        'slug',
        'icon',
        'path',
        'image',
        'description',
        'color',
        'status',
        'level',
        'position',
        'en_name',
        'visible_in_menu',
        'meta_keyword',
        'meta_description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function attributeSets(): BelongsTo
    {
        return $this->belongsTo(AttributeSet::class);
    }
}
