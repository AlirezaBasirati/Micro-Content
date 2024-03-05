<?php

namespace App\Services\CommentService\V1\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property Integer $id
 * @property Integer $user_id
 * @property Integer $parent_id
 * @property String $title
 * @property String $body
 * @property Integer $status
 * @property String $positive_points
 * @property String $negative_points
 * @property Integer $rate
 * @property Integer $product_id
 * @property Comment $parent
 * @property Collection $children
 * @property Collection $recommendations
 * @property Collection $rates
 * @property Collection $images
 */
class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'user_id',
        'full_name',
        'parent_id',
        'title',
        'body',
        'status',
        'positive_points',
        'negative_points',
        'rate',
        'product_id',
    ];

    protected $casts = [
        'positive_points' => 'array',
        'negative_points' => 'array',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function recommendations(): HasMany
    {
        return $this->hasMany(Recommendation::class);
    }

    public function rates(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
}
