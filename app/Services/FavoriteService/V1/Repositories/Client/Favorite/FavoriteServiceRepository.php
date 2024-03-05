<?php

namespace App\Services\FavoriteService\V1\Repositories\Client\Favorite;

use App\Services\FavoriteService\V1\Models\Favorite;
use Celysium\Authenticate\Facades\Authenticate;
use Celysium\Base\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class FavoriteServiceRepository extends BaseRepository implements FavoriteServiceInterface
{
    public function __construct(Favorite $model)
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

        return parent::store($parameters);
    }

    public function isFavorite(array $parameters): bool
    {
        return Favorite::query()
            ->where('user_id', Authenticate::id())
            ->where('product_id', $parameters['product_id'])->exists();
    }

    public function unfavorite(array $parameters): void
    {
        Favorite::query()
            ->where('user_id', Authenticate::id())
            ->where('product_id', $parameters['product_id'])->delete();
    }
}
