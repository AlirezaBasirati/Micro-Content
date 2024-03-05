<?php

namespace App\Services\CommentService\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property Integer $comment_id
 * @property Integer $status
 * @property Comment $comment
 */
class Recommendation extends Model
{
    use HasFactory;
    use SoftDeletes;

    const DIS_LIKE = 0;
    const LIKED = 1;

    protected $fillable = [
        'comment_id',
        'user_id',
        'status',
    ];

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
