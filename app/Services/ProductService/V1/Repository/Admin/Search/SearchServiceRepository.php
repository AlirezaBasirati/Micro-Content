<?php

namespace App\Services\ProductService\V1\Repository\Admin\Search;

use App\Services\ProductService\V1\Models\Search;
use Celysium\Authenticate\Facades\Authenticate;
use Illuminate\Database\Eloquent\Builder;
use Celysium\Base\Repository\BaseRepository;
use JetBrains\PhpStorm\Pure;

class SearchServiceRepository extends BaseRepository implements SearchServiceInterface
{
    #[Pure] public function __construct(Search $model)
    {
        parent::__construct($model);
    }

    public function query(Builder $query, array $parameters = []): Builder
    {
        $userId = Authenticate::id();
        $query->where('user_id', $userId)->orderByDesc('created_at')->take(3)->get();

        return $query;
    }
}
