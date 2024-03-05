<?php

namespace App\Services\ContentManagerService\V1\Database\Factories;

use App\Services\ContentManagerService\V1\Models\SliderPosition;
use Illuminate\Database\Eloquent\Factories\Factory;

class SliderPositionFactory extends Factory
{

    protected $model = SliderPosition::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'slug'  => $this->faker->slug,
        ];
    }
}
