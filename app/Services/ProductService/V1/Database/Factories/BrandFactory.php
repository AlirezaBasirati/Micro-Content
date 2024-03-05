<?php

namespace App\Services\ProductService\V1\Database\Factories;

use App\Services\ProductService\V1\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{

    protected $model = Brand::class;

    public function definition(): array
    {
        return [
            'name'            => $this->faker->name,
            'slug'            => $this->faker->slug,
            'description'     => $this->faker->text,
            'manufactured_in' => $this->faker->city,
            'en_name'         => $this->faker->name,
            'image'           => $this->faker->imageUrl,
            'thumbnail'       => $this->faker->imageUrl,
            'is_featured'     => rand(0, 1),
            'status'          => rand(0, 1),
        ];
    }
}
