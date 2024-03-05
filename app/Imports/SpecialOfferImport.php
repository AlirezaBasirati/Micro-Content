<?php

namespace App\Imports;

use App\Services\ProductService\Models\Product;
use App\Services\SpecialOfferService\Models\SpecialOffer;
use App\Services\SpecialOfferService\Repository\SpecialOfferServiceInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SpecialOfferImport implements ToCollection, WithHeadingRow
{
    public function __construct()
    {
    }

    public function collection(Collection $collection): void
    {
        $products = Product::query()
            ->whereIn('sku', $collection->pluck('sku')->toArray())
            ->get(['id', 'sku']);

        $specialOffers = [];
        foreach ($collection as $specialOfferRequest) {
            $product = $products->where('sku', $specialOfferRequest['sku'])->first();
            if ($product) {
                $newSpecialOffers = [
                    'product_id' => $products->where('sku', $specialOfferRequest['sku'])->first()->id,
                    'available_from' => Carbon::make($specialOfferRequest['available_from'])->startOfDay()->format('Y-m-d H:i:s'),
                    'available_to' => Carbon::make($specialOfferRequest['available_to'])->endOfDay()->format('Y-m-d H:i:s'),
                ];

                if (SpecialOffer::query()
                        ->where('product_id', $newSpecialOffers['product_id'])
                        ->where('available_from', $newSpecialOffers['available_from'])
                        ->where('available_to', $newSpecialOffers['available_to'])
                        ->count() == 0) {
                    $specialOffers[] = $newSpecialOffers;
                }

            }
        }
        SpecialOffer::query()
            ->insert($specialOffers);
    }
}
