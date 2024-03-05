<?php

namespace App\Services\FavoriteService\V1\Repositories\Client\Favorite;

use Celysium\Base\Repository\BaseRepositoryInterface;

interface FavoriteServiceInterface extends BaseRepositoryInterface
{
    public function isFavorite(array $parameters): bool;

    public function unfavorite(array $parameters): void;
}
