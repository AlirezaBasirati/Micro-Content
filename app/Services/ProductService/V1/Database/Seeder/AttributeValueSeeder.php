<?php

namespace App\Services\ProductService\V1\Database\Seeder;

use App\Services\ProductService\V1\Models\AttributeValue;
use Illuminate\Database\Seeder;

class AttributeValueSeeder extends Seeder
{
    public function run(): void
    {
        AttributeValue::query()->create([
            'value'        => 'blue',
            'attribute_id' => 1,
        ]);

        AttributeValue::query()->create([
            'value'        => '1400-09-01',
            'attribute_id' => 3,
        ]);

        AttributeValue::query()->create([
            'value'        => 's',
            'attribute_id' => 2,
        ]);
    }
}
