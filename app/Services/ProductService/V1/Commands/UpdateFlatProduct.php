<?php

namespace App\Services\ProductService\V1\Commands;

use App\Services\Migrator\Migrator;
use App\Services\ProductService\V1\Models\FlatProduct;
use App\Services\ProductService\V1\Models\Product;
use App\Services\ProductService\V1\Repository\Admin\FlatProduct\FlatProductServiceInterface as FlatProductServiceRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UpdateFlatProduct extends Migrator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:flat_product {only?*} {--sku=} {--chunk=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Flat Products Data From MySql into Mongodb.';

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
        return FlatProduct::query()
            ->when($this->option('sku'), fn($query, $sku) => $query->where('sku', $sku))
            ->paginate($this->chunkSize, ['*'], 'page', $page);
    }

    public function reset()
    {
        //
    }

    public function bulkInsert(array $data)
    {
        foreach ($data as $item) {
            /** @var Product $product */
            $product = Product::query()->where('sku', $item['sku'])->first();

            /** @var FlatProduct $item */
            $item->fill($this->flatProductServiceRepository->mapper($product, $this->argument('only')));
            $this->flatProductServiceRepository->modifyStock([], $item);

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
