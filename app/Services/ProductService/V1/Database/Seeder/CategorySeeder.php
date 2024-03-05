<?php

namespace App\Services\ProductService\V1\Database\Seeder;

use App\Services\ProductService\V1\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        Category::query()->create([
            'title'           => 'root',
            'parent_id'       => null,
            'slug'            => 'root',
            'icon'            => fake()->imageUrl,
            'image'           => fake()->imageUrl,
            'path'            => [],
            'status'          => 1,
            'level'           => 0,
            'position'        => 1,
            'visible_in_menu' => 1,
        ]);

        Category::query()->create([
            'title'           => 'لبنیات',
            'parent_id'       => 1,
            'slug'            => 'dairy',
            'icon'            => fake()->imageUrl,
            'image'           => fake()->imageUrl,
            'path'            => [],
            'status'          => 1,
            'level'           => 1,
            'position'        => 1,
            'visible_in_menu' => 1,
        ]);

        Category::query()->create([
            'title'           => 'نوشیدنی',
            'parent_id'       => 1,
            'slug'            => 'beverage',
            'icon'            => fake()->imageUrl,
            'image'           => fake()->imageUrl,
            'path'            => [],
            'status'          => 1,
            'level'           => 1,
            'position'        => 2,
            'visible_in_menu' => 1,
        ]);

        Category::query()->create([
            'title'           => 'شیر',
            'parent_id'       => 2,
            'slug'            => 'milk',
            'icon'            => fake()->imageUrl,
            'image'           => fake()->imageUrl,
            'path'            => [],
            'status'          => 1,
            'level'           => 2,
            'position'        => 1,
            'visible_in_menu' => 1,
        ]);

        Category::query()->create([
            'title'           => 'ماست',
            'parent_id'       => 2,
            'slug'            => 'yogurt',
            'icon'            => fake()->imageUrl,
            'image'           => fake()->imageUrl,
            'path'            => [],
            'status'          => 1,
            'level'           => 2,
            'position'        => 2,
            'visible_in_menu' => 1,
        ]);

        Category::query()->create([
            'title'           => 'نوشابه',
            'parent_id'       => 3,
            'slug'            => 'drinks',
            'icon'            => fake()->imageUrl,
            'image'           => fake()->imageUrl,
            'path'            => [],
            'status'          => 1,
            'level'           => 2,
            'position'        => 1,
            'visible_in_menu' => 1,
        ]);

        Category::query()->create([
            'title'           => 'آب',
            'parent_id'       => 3,
            'slug'            => 'water',
            'icon'            => fake()->imageUrl,
            'image'           => fake()->imageUrl,
            'path'            => [],
            'status'          => 1,
            'level'           => 2,
            'position'        => 2,
            'visible_in_menu' => 1,
        ]);

        Category::query()->create([
            'title'           => 'خامه',
            'parent_id'       => 2,
            'slug'            => 'cream',
            'icon'            => fake()->imageUrl,
            'image'           => fake()->imageUrl,
            'path'            => [],
            'status'          => 1,
            'level'           => 2,
            'position'        => 1,
            'visible_in_menu' => 1,
        ]);

        Category::query()->create([
            'title'           => 'پنیر',
            'parent_id'       => 2,
            'slug'            => 'cheese',
            'icon'            => fake()->imageUrl,
            'image'           => fake()->imageUrl,
            'path'            => [],
            'status'          => 1,
            'level'           => 2,
            'position'        => 2,
            'visible_in_menu' => 1,
        ]);

        foreach (Category::query()->orderBy('level')->get() as $category) {

            /** @var Category $category */
            if ($category->parent_id) {
                $category['path'] = array_merge($category->parent->path, [$category->only(['id', 'title'])]);
                $category->save();
            }
        }
    }
}
