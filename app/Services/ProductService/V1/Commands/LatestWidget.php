<?php

namespace App\Services\ProductService\V1\Commands;

use App\Services\ProductService\V1\Models\Category;
use App\Services\ProductService\V1\Models\Widget;
use App\Services\ProductService\V1\Repository\Admin\Widget\WidgetServiceInterface as WidgetServiceRepository;
use Illuminate\Console\Command;

class LatestWidget extends Command
{
    protected $signature = 'widget:latest {categoryId?*} {--take=20}';
    protected $description = 'Create latest widget';

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
            $slug = 'latest' . '_' . 'main';
        else
            $slug = 'latest' . '_' . $slug;

        $productSkus = $this->widgetServiceRepository->latestProducts($this->argument('categoryId'), $this->option('take'));

        /** @var Widget $widget */
        $widget = Widget::query()->firstOrCreate(
            ['slug' => $slug],
            ['name' => 'latest']
        );

        $widget->products()->detach();
        $this->widgetServiceRepository->assignProducts($widget, $productSkus);
    }
}
