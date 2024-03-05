<?php

namespace App\Services\SpecialOfferService\V1\Repository;

use Celysium\Base\Repository\BaseRepositoryInterface;

interface SpecialOfferServiceInterface extends BaseRepositoryInterface
{
    public function syncProducts(array $productIds): bool;
}
