<?php

namespace App\Services\ProductService\V1\Database\Seeder;

use App\Services\ProductService\V1\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        Brand::query()->create([
            'name'            => 'میهن',
            'description'     => 'mihan',
            'slug'            => 'mihan',
            'en_name'         => 'mihan',
            'manufactured_in' => 'iran',
            'thumbnail'       => fake()->imageUrl,
            'status'          => 1,
            'is_featured'     => 1,
        ]);

        Brand::query()->create([
            'name'            => 'برفود',
            'description'     => 'berfod',
            'slug'            => 'berfod',
            'en_name'         => 'berfod',
            'manufactured_in' => 'iran',
            'thumbnail'       => fake()->imageUrl,
            'status'          => 1,
            'is_featured'     => 1,
        ]);

        Brand::query()->create([
            'name'            => 'کاله',
            'description'     => 'kaleh',
            'slug'            => 'kaleh',
            'en_name'         => 'kaleh',
            'manufactured_in' => 'iran',
            'thumbnail'       => fake()->imageUrl,
            'status'          => 1,
            'is_featured'     => 1,
        ]);

        Brand::query()->create([
            'name'            => 'سولی',
            'description'     => 'soltan',
            'slug'            => 'soltan',
            'en_name'         => 'soltan',
            'manufactured_in' => 'iran',
            'thumbnail'       => fake()->imageUrl,
            'status'          => 1,
            'is_featured'     => 1,
        ]);

        Brand::query()->create([
            'name'            => 'گوجیی',
            'description'     => 'gucci',
            'slug'            => 'gucci',
            'en_name'         => 'gucci',
            'manufactured_in' => 'iran',
            'thumbnail'       => fake()->imageUrl,
            'status'          => 1,
            'is_featured'     => 1,
        ]);
    }
}
