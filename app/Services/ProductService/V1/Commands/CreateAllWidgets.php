<?php

namespace App\Services\ProductService\V1\Commands;

use App\Services\ProductService\V1\Models\Category;
use App\Services\ProductService\V1\Repository\Client\Category\CategoryServiceRepository as CategoryServiceRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CreateAllWidgets extends Command
{
    protected $signature = 'widget:all {category?} {id?} {take=20}';
    protected $description = 'Create all category widgets';

    public function __construct(private readonly CategoryServiceRepository $categoryServiceRepository)
    {
        parent::__construct();
    }

    public function handle()
    {
        switch ($this->argument('category')) {
            case "main":
                Artisan::call('widget:best_seller');
                Artisan::call('widget:incredible');
                Artisan::call('widget:latest');
                Artisan::call('widget:most_viewed');
                break;

            case "categories":
                $categoryIds = Category::query()
                    ->where('parent_id', 2)
                    ->where('status', 1)
                    ->where('visible_in_menu', 1)
                    ->where('level', 0)
                    ->orderBy('position')
                    ->take(10)
                    ->pluck('id');

                foreach ($categoryIds as $categoryId) {
                    Artisan::call('widget:best_seller', ['categoryId' => $categoryId]);
                    Artisan::call('widget:incredible', ['categoryId' => $categoryId]);
                    Artisan::call('widget:latest', ['categoryId' => $categoryId]);
                    Artisan::call('widget:most_viewed', ['categoryId' => $categoryId]);
                }
                break;

            case "category":
                Artisan::call('widget:best_seller', ['categoryId' => $this->argument('id')]);
                Artisan::call('widget:incredible', ['categoryId' => $this->argument('id')]);
                Artisan::call('widget:latest', ['categoryId' => $this->argument('id')]);
                Artisan::call('widget:most_viewed', ['categoryId' => $this->argument('id')]);
                break;

            default:
                $categoryIds = Category::query()
                    ->where('parent_id', 2)
                    ->where('status', 1)
                    ->where('visible_in_menu', 1)
                    ->where('level', 0)
                    ->orderBy('position')
                    ->take(10)
                    ->pluck('id');

                Artisan::call('widget:best_seller');
                Artisan::call('widget:incredible');
                Artisan::call('widget:latest');
                Artisan::call('widget:most_viewed');

                foreach ($categoryIds as $categoryId) {
                    $categories = $this->categoryServiceRepository->getChildren($categoryId)->pluck('id')->toArray();
                    Artisan::call('widget:best_seller', ['categoryId' => $categories]);
                    Artisan::call('widget:incredible', ['categoryId' => $categories]);
                    Artisan::call('widget:latest', ['categoryId' => $categories]);
                    Artisan::call('widget:most_viewed', ['categoryId' => $categories]);
                }
        }
    }
}
