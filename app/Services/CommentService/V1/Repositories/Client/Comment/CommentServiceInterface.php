<?php

namespace App\Services\CommentService\V1\Repositories\Client\Comment;

use App\Services\CommentService\V1\Models\Comment;
use Celysium\Base\Repository\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

interface CommentServiceInterface extends BaseRepositoryInterface
{
    public function createRating(Comment $comment, array $parameters): Model;

    public function createRecommendation(Comment $comment, array $parameters): Model;
}
