<?php

namespace App\Imports;

use App\Services\CampaignService\V1\Models\Campaign;
use App\Services\CampaignService\V1\Repository\CampaignServiceInterface;
use App\Services\ProductService\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CampaignImport implements ToCollection, WithHeadingRow
{
    public function __construct(private readonly CampaignServiceInterface $campaignService, private readonly Campaign $campaign)
    {
    }

    public function collection(Collection $collection): void
    {
        $skus = $collection->pluck('sku')->toArray();

        $productIds = Product::query()
            ->whereIn('sku', $skus)
            ->pluck('id');

        $campaign = $this->campaignService->assignProducts($this->campaign, $productIds->toArray());
    }
}
