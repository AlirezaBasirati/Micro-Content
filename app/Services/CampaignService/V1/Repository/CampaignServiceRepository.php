<?php

namespace App\Services\CampaignService\V1\Repository;

use App\Services\CampaignService\V1\Models\Campaign;
use App\Services\ContentManagerService\V1\Models\Slider;
use App\Services\ContentManagerService\V1\Models\SliderPosition;
use App\Services\ProductService\V1\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Celysium\Base\Repository\BaseRepository;

class CampaignServiceRepository extends BaseRepository implements CampaignServiceInterface
{
    public function __construct(Campaign $model)
    {
        parent::__construct($model);
    }

    public function store(array $parameters): Model
    {
        /** @var Campaign $campaign */
        $campaign = parent::store($parameters);
        $this->createSliders($campaign);

        return $campaign;
    }

    public function assignProducts(Campaign $campaign, array $productIds): Campaign
    {
        if (!is_numeric(Arr::first($productIds))) {
            $productIds = Product::query()
                ->whereIn('sku', $productIds)
                ->pluck('id')
                ->toArray();
        }
        $campaign->products()->sync($productIds);

        return $campaign;
    }

    private function createSliders(Campaign $campaign): void
    {
        /** @var SliderPosition $desktopPosition */
        $desktopPosition = SliderPosition::query()
            ->create([
                'title'     => 'کمپین ' . $campaign->name,
                'slug'      => 'campaign-' . $campaign->slug . '-' . '1' . '-desktop',
                'max_width' => '1920',
            ]);

        Slider::query()
            ->create([
                'title'       => 'کمپین ' . $campaign->name . ' ' . 'desktop',
                'type'        => 'banner',
                'position_id' => $desktopPosition->id,
                'status'      => 1,
                'height'      => 200,
                'width'       => 300,
            ]);

        /** @var SliderPosition $mobilePosition */
        $mobilePosition = SliderPosition::query()
            ->create([
                'title'     => 'کمپین ' . $campaign->name,
                'slug'      => 'campaign-' . $campaign->slug . '-' . '1',
                'max_width' => '640',
            ]);

        Slider::query()
            ->create([
                'title'       => 'کمپین ' . $campaign->name . ' ' . 'mobile',
                'type'        => 'banner',
                'position_id' => $mobilePosition->id,
                'status'      => 1,
                'height'      => 200,
                'width'       => 300,
            ]);
    }
}
