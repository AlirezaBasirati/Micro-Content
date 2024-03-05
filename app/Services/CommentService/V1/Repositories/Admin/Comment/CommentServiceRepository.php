<?php

namespace App\Services\CommentService\V1\Repositories\Admin\Comment;

use App\Services\CommentService\V1\Models\Comment;
use Celysium\Base\Repository\BaseRepository;

class CommentServiceRepository extends BaseRepository implements CommentServiceInterface
{
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }
}
