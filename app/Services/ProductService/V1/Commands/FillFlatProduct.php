<?php

namespace App\Services\ProductService\V1\Commands;

use App\Services\Migrator\Migrator;
use App\Services\ProductService\V1\Models\FlatProduct;
use App\Services\ProductService\V1\Models\Product;
use App\Services\ProductService\V1\Repository\Admin\FlatProduct\FlatProductServiceInterface as FlatProductServiceRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FillFlatProduct extends Migrator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill:flat_product {only?*} {--sku=} {--merchant=} {--store=} {--chunk=100} {--truncate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate Products Data From MySql into Mongodb.';

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
            ->paginate($this->chunkSize, ['*'], 'page', $page);
    }

    public function reset()
    {
        if ($this->option('truncate')) {
            FlatProduct::query()->truncate();
        }
    }

    public function bulkInsert(array $data)
    {
        /** @var Product $item */
        foreach ($data as $item) {
            $original = rand(1, 1000) * 1000;
            $status = 1;

            $parameter = [
                'sku'            => $item->sku,
                'store_id'       => (int)($this->option('store') ?? 1),
                'merchant_id'    => (int)($this->option('merchant') ?? 1),
                'price_original' => $original,
                'price_promoted' => $original - ($original * rand(0, 30) * 0.01),
                'status'         => $status,
                'quantity'       => rand(1, 100),
            ];

            /** @var FlatProduct $flatProduct */
            $flatProduct = $this->flatProductServiceRepository->findBySku($parameter);
            if ($flatProduct) {
                $data = array_merge($parameter, $this->flatProductServiceRepository->mapper($item, $this->argument('only')));
                $flatProduct->fill($data);
                $this->flatProductServiceRepository->modifyStock($parameter, $flatProduct);
            } else {
                $this->flatProductServiceRepository->make($parameter);
            }
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
