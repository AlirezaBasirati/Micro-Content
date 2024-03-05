<?php

namespace App\Services\ProductService\V1\Commands;

use App\Services\Migrator\Migrator;
use App\Services\ProductService\V1\Models\FlatProduct;
use App\Services\ProductService\V1\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FillPriceFlatProduct extends Migrator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill:price_flat_product {--chunk=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill price flat product';

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
        return FlatProduct::query()
            ->paginate($this->chunkSize, ['*'], 'page', $page);
    }

    public function reset()
    {
        //
    }

    public function bulkInsert(array $data)
    {
        /** @var Product $item */
        foreach ($data as $item) {
            /** @var FlatProduct $item */
            $item->price = $item->price_promoted ?: $item->price_original;
            $item->discounted_percent = ($item->price_original != 0 && $item->price_promoted) ? round(($item->price_original - $item->price_promoted) / $item->price_original * 100) : 0;
            $item->save();
        }
    }

    public function mapper(array $item): ?array
    {
        return $item;
    }

    public function count(): int
    {
        return FlatProduct::query()->count();
    }
}
