<?php

namespace App\Services\ProductService\V1\Commands;

use App\Services\ProductService\V1\Models\Category;
use App\Services\ProductService\V1\Models\Widget;
use App\Services\ProductService\V1\Repository\Admin\Widget\WidgetServiceInterface as WidgetServiceRepository;
use Illuminate\Console\Command;

class BestSellerWidget extends Command
{
    protected $signature = 'widget:best_seller {categoryId?*} {--take=20}';
    protected $description = 'Create best seller widget';

    public function __construct(private readonly WidgetServiceRepository $widgetServiceRepository)
    {
        parent::__construct();
    }

    public function handle()
    {
        $categoryId = $this->argument('categoryId') ? $this->argument('categoryId')[0] : null;
        if (!is_null($categoryId))
            $slug = Category::query()->find($categoryId)->slug;

        if (trim($categoryId) == '')
            $slug = 'best_seller' . '_' . 'main';
        else
            $slug = 'best_seller' . '_' . $slug;

        $productIds = $this->widgetServiceRepository->bestSellerProducts($this->argument('categoryId'), $this->option('take'));

        /** @var Widget $widget */
        $widget = Widget::query()->firstOrCreate(
            ['slug' => $slug],
            ['name' => 'best seller']
        );

        $widget->products()->sync($productIds);
    }
}
