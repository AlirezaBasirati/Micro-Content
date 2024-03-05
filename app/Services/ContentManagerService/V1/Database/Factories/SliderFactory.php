<?php

namespace App\Services\ContentManagerService\V1\Database\Factories;

use App\Services\ContentManagerService\V1\Models\Slider;
use Illuminate\Database\Eloquent\Factories\Factory;

class SliderFactory extends Factory
{

    protected $model = Slider::class;

    public function definition(): array
    {
        return [
            'type'        => 'simple',
            'position_id' => $this->faker->randomDigitNotNull,
            'status'      => 1,
            'height'      => '100',
            'width'       => '100',
            'title'       => $this->faker->title,
        ];
    }
}
