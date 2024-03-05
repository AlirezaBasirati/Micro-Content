<?php

namespace App\Services\ContentManagerService\V1\Database\Factories;

use App\Services\ContentManagerService\V1\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqFactory extends Factory
{

    protected $model = Faq::class;

    public function definition(): array
    {
        return [
            'question' => $this->faker->city,
            'answer'   => $this->faker->streetName,
            'status'   => 1,
        ];
    }
}
