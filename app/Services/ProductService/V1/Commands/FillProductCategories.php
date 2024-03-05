<?php

namespace App\Services\ProductService\V1\Commands;

use App\Services\Migrator\Migrator;
use App\Services\ProductService\V1\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FillProductCategories extends Migrator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill:product_categories {only?*} {--sku=} {--chunk=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Correct Product Categories Data.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getData(int $page): LengthAwarePaginator
    {
        return Product::query()
            ->when($this->option('sku'), fn($query, $sku) => $query->where('sku', $sku))
            ->paginate($this->chunkSize, ['*'], 'page', $page);
    }

    public function reset()
    {
    }

    public function bulkInsert(array $data)
    {
        /** @var Product $item */
        foreach ($data as $item) {
            $categories = $item->categories->pluck('parent_id', 'id')->toArray();
            if (count($categories) > 1) {
                foreach ($categories as $id => $parent) {
                    if (in_array($id, $categories) || $parent == 2) {
                        unset($categories[$id]);
                    }
                }
                $categories = $item->categories->whereIn('id', array_keys($categories));
                $item->categories()->sync((count($categories) > 0) ? [$categories->first()->id] : []);
            }

        }
    }

    public function mapper(array $item): ?array
    {
        return $item;
    }

    public function count(): int
    {
        return Product::query()->count();
    }
}
