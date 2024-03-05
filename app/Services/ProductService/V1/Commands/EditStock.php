<?php

namespace App\Services\ProductService\V1\Commands;

use App\Services\Migrator\Migrator;
use App\Services\ProductService\V1\Models\FlatProduct;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EditStock extends Migrator
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'edit:is_in_stock {--chunk=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Edit Is In Stock Data.';

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
            ->where('price_original', 0)
            ->orWhereNull('price_original')
            ->paginate($this->chunkSize, ['*'], 'page', $page);
    }

    public function reset()
    {
        //
    }

    public function bulkInsert(array $data)
    {
        /** @var FlatProduct $item */
        foreach ($data as $item) {
            if ($item['price_original'] == 0) {
                $item->update([
                    'is_in_stock' => 0
                ]);
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
