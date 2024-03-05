<?php

namespace App\Services\ProductService\V1\Jobs;

use App\Events\ProductUpdate;
use App\Services\ProductService\V1\Models\Attribute;
use App\Services\ProductService\V1\Models\AttributeValue;
use App\Services\ProductService\V1\Models\FlatProduct;
use App\Services\ProductService\V1\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use function event;

class UpdateProductImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(public array $item)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        /** @var Product $product */
        $product = Product::query()->where('sku', $this->item['sku'])->first();

        if (is_null($product)) {
            return;
        }
        if (isset($this->item['max_in_cart']) && is_numeric($this->item['max_in_cart']) && $this->item['max_in_cart'] >= 0) {
            Product::query()->where('sku', $this->item['sku'])
                ->update([
                    'max_in_cart' => $this->item['max_in_cart'],
                ]);
            FlatProduct::query()->where('sku', $this->item['sku'])
                ->update([
                    'max_in_cart' => $this->item['max_in_cart'],
                ]);
        }
        if (isset($this->item['lead_time']) && is_numeric($this->item['lead_time']) && $this->item['lead_time'] >= 0) {
            /** @var Attribute $attribute */
            $attribute = Attribute::query()
                ->where('slug', 'ready_to_ship_lead_time')
                ->first();

            /** @var AttributeValue $attributeValue */
            $attributeValue = AttributeValue::query()->firstOrCreate([
                'attribute_id' => $attribute->id,
                'value'        => $this->item['lead_time'],
            ]);

            $product->productValues()
                ->where('attribute_id', $attribute->id)
                ->whereNot('attribute_value_id', $attributeValue->id)
                ->delete();

            $product->productValues()->updateOrCreate([
                'product_id'         => $product->id,
                'attribute_id'       => $attribute->id,
                'attribute_value_id' => $attributeValue->id,
            ]);
            event(new ProductUpdate($product));
        }
    }
}
