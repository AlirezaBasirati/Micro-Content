<?php

namespace App\Services\ProductService\V1\Commands;

use App\Services\Migrator\Migrator;
use App\Services\ProductService\V1\Models\FlatProduct;
use App\Services\ProductService\V1\Models\Product;
use App\Services\ProductService\V1\Repository\Client\FlatProduct\FlatProductServiceInterface as FlatProductServiceRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SyncFlatProduct extends Migrator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:flat_product {only?*} {--sku=} {--from=} {--merchant=} {--store=} {--chunk=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Products Data From MySql into Mongodb.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private readonly FlatProductServiceRepository $flatProductServiceRepository)
    {
        parent::__construct();
    }

    public function getData(int $page): LengthAwarePaginator
    {
        return Product::query()
            ->when($this->option('sku'), fn($query, $sku) => $query->where('sku', $sku))
            ->when($this->option('from'), fn($query, $date) => $query->where('updated_at', '>', $date))
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
            $parameter = [
                'sku' => $item->sku,
                'store_id' => (int)($this->option('store') ?? 1),
                'batch_id' => null,
                'merchant_id' => (int)($this->option('merchant') ?? 1),
                'price_original' => 0,
                'price_promoted' => null,
                'status' => 0,
                'quantity' => 0,
            ];

            $this->flatProductServiceRepository->saveFlatProduct($parameter);
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
