<?php

namespace App\Services\CampaignService\V1\Repository;

use App\Services\CampaignService\V1\Models\Campaign;
use Celysium\Base\Repository\BaseRepositoryInterface;

interface CampaignServiceInterface extends BaseRepositoryInterface
{
    public function assignProducts(Campaign $campaign, array $productIds): Campaign;
}
