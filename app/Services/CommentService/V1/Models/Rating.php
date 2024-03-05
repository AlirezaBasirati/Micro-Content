<?php

namespace App\Services\CommentService\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property Integer $comment_id
 * @property Integer $score
 * @property Comment $comment
 */
class Rating extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'comment_id',
        'user_id',
        'score',
    ];

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
