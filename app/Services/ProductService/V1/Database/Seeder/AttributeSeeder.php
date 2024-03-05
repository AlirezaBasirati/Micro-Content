<?php

namespace App\Services\ProductService\V1\Database\Seeder;

use App\Services\ProductService\V1\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    public function run(): void
    {
        Attribute::query()->create([
            'title'   => 'color',
            'type'    => 'drop down',
            'slug'    => 'color',
            'status'  => 1,
            'visible' => 1,
        ]);

        Attribute::query()->create([
            'title'   => 'size',
            'type'    => 'option',
            'slug'    => 'size',
            'status'  => 1,
            'visible' => 1,
        ]);

        Attribute::query()->create([
            'title'   => 'exp. date',
            'type'    => 'date',
            'slug'    => 'exp-date',
            'status'  => 1,
            'visible' => 1,
        ]);

        Attribute::query()->create([
            'title'   => 'type',
            'type'    => 'text',
            'slug'    => 'type',
            'status'  => 1,
            'visible' => 1,
        ]);
    }
}
