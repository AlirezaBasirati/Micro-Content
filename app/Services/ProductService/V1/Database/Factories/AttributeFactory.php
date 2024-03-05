<?php

namespace App\Services\ProductService\V1\Database\Factories;

use App\Services\ProductService\V1\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeFactory extends Factory
{

    protected $model = Attribute::class;

    public function definition(): array
    {
        return [
            'title'              => $this->faker->title,
            'slug'               => $this->faker->slug,
            'type'               => 'simple',
            'searchable'         => rand(0, 1),
            'filterable'         => rand(0, 1),
            'comparable'         => rand(0, 1),
            'attribute_group_id' => $this->faker->randomDigitNotNull,
            'visible'            => rand(0, 1),
            'status'             => rand(0, 1),
        ];
    }
}
