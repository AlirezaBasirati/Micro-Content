<?php

namespace App\Services\ContentManagerService\V1\Database\Seeder;

use App\Services\ContentManagerService\V1\Models\Slider;
use App\Services\ContentManagerService\V1\Models\SliderItem;
use App\Services\ContentManagerService\V1\Models\SliderPosition;
use Celysium\Media\Facades\Media;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $firstPosition = SliderPosition::query()
            ->create([
                'title' => 'main-1',
                'slug'  => 'main-1',
            ]);

        $secondPosition = SliderPosition::query()
            ->create([
                'title' => 'main-2',
                'slug'  => 'main-2',
            ]);

        $thirdPosition = SliderPosition::query()
            ->create([
                'title' => 'main-3',
                'slug'  => 'main-3',
            ]);

        $forthPosition = SliderPosition::query()
            ->create([
                'title' => 'main-4',
                'slug'  => 'main-4',
            ]);


        $slider1 = Slider::query()
            ->create([
                'title'       => 'first banner',
                'type'        => 'banner',
                'position_id' => $firstPosition->id,
                'status'      => 1,
                'height'      => 200,
                'width'       => 300,
            ]);

        $slider2 = Slider::query()
            ->create([
                'title'       => 'image slider 1',
                'type'        => 'slider',
                'position_id' => $secondPosition->id,
                'status'      => 1,
                'height'      => 200,
                'width'       => 300,
            ]);

        $slider3 = Slider::query()
            ->create([
                'title'       => 'image slider 2',
                'type'        => 'slider',
                'position_id' => $secondPosition->id,
                'status'      => 1,
                'height'      => 200,
                'width'       => 300,
            ]);

        $slider4 = Slider::query()
            ->create([
                'title'       => 'image slider 3',
                'type'        => 'slider',
                'position_id' => $thirdPosition->id,
                'status'      => 1,
                'height'      => 200,
                'width'       => 300,
            ]);

        $slider5 = Slider::query()
            ->create([
                'title'       => 'image slider 4',
                'type'        => 'slider',
                'position_id' => $thirdPosition->id,
                'status'      => 1,
                'height'      => 200,
                'width'       => 300,
            ]);

        $slider6 = Slider::query()
            ->create([
                'title'       => 'image slider 5',
                'type'        => 'slider',
                'position_id' => $forthPosition->id,
                'status'      => 1,
                'height'      => 200,
                'width'       => 300,
            ]);

        SliderItem::query()
            ->create([
                'title'     => 'banner item 1',
                'url'       => null,
                'status'    => 1,
                'slider_id' => $slider1->id,
                'image_url' => Storage::path('images/item-1'),
            ]);

        SliderItem::query()
            ->create([
                'title'     => 'banner item 2',
                'url'       => null,
                'status'    => 1,
                'slider_id' => $slider1->id,
                'image_url' => Storage::path('images/item-2'),
            ]);

        SliderItem::query()
            ->create([
                'title'     => 'banner item 3',
                'url'       => null,
                'status'    => 1,
                'slider_id' => $slider1->id,
                'image_url' => Storage::path('images/item-1'),
            ]);

        SliderItem::query()
            ->create([
                'title'     => 'item 1',
                'url'       => null,
                'status'    => 1,
                'slider_id' => $slider2->id,
                'image_url' => Storage::path('images/item-1'),
            ]);

        SliderItem::query()
            ->create([
                'title'     => 'item 1',
                'url'       => null,
                'status'    => 1,
                'slider_id' => $slider3->id,
                'image_url' => Storage::path('images/item-1'),
            ]);

        SliderItem::query()
            ->create([
                'title'     => 'item 1',
                'url'       => null,
                'status'    => 1,
                'slider_id' => $slider4->id,
                'image_url' => Storage::path('images/item-1'),
            ]);

        SliderItem::query()
            ->create([
                'title'     => 'item 1',
                'url'       => null,
                'status'    => 1,
                'slider_id' => $slider5->id,
                'image_url' => Storage::path('images/item-1'),
            ]);

        SliderItem::query()
            ->create([
                'title'     => 'item 1',
                'url'       => null,
                'status'    => 1,
                'slider_id' => $slider6->id,
                'image_url' => Storage::path('images/item-1'),
            ]);

    }
}
