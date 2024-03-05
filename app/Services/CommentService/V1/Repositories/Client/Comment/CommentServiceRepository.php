<?php

namespace App\Services\CommentService\V1\Repositories\Client\Comment;

use App\Services\CommentService\V1\Models\Comment;
use App\Services\CommentService\V1\Models\Recommendation;
use Celysium\Authenticate\Facades\Authenticate;
use Celysium\Base\Repository\BaseRepository;
use Celysium\Media\Facades\Media;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CommentServiceRepository extends BaseRepository implements CommentServiceInterface
{
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    public function query(Builder $query, array $parameters): Builder
    {
        $query->where('user_id', Authenticate::id());

        return $query;
    }

    public function store(array $parameters): Model
    {
        $parameters['user_id'] = Authenticate::id();
        $parameters['full_name'] = Authenticate::name();

        /** @var Comment $comment */
        $comment = Comment::query()->create($parameters);

        if ($parameters['files']) {
            foreach ($parameters['files'] as $file) {
                $url = Media::upload($file);
                $comment->images()->create([
                    'user_id'    => Authenticate::id(),
                    'comment_id' => $comment->id,
                    'file'       => $url,
                ]);
            }
        }

        return $comment;
    }

    public function createRating(Comment $comment, array $parameters): Model
    {
        $uniqueByParameters = [
            'user_id'    => Authenticate::id(),
            'comment_id' => $comment->id,
        ];

        return $comment->rates()->updateOrCreate($uniqueByParameters, $parameters);
    }

    public function createRecommendation(Comment $comment, array $parameters): Model
    {
        $uniqueByParameters = [
            'user_id'    => Authenticate::id(),
            'comment_id' => $comment->id,
        ];

        $parameters = [
            'status' => $this->findMatchedStatusRecommendation($parameters['status']),
        ];

        return $comment->recommendations()->updateOrCreate($uniqueByParameters, $parameters);
    }

    public function findMatchedStatusRecommendation(string $status): int
    {
        return match ($status) {
            'like' => Recommendation::LIKED,
            'dislike' => Recommendation::DIS_LIKE,
        };
    }
}
