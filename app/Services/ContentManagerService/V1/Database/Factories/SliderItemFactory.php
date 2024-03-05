<?php

namespace App\Services\ContentManagerService\V1\Database\Factories;

use App\Services\ContentManagerService\V1\Models\SliderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class SliderItemFactory extends Factory
{

    protected $model = SliderItem::class;

    public function definition(): array
    {
        return [
            'title'     => $this->faker->title,
            'url'       => $this->faker->url,
            'status'    => 1,
            'slider_id' => 1,
            'image_url' => $this->faker->imageUrl,
        ];
    }
}
