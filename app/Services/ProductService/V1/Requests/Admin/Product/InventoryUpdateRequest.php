<?php

namespace App\Services\ProductService\V1\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class InventoryUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'inventories'               => 'required|array',
            'inventories.*.sku'         => 'required|string',
            'inventories.*.store_id'    => 'required|numeric',
            'inventories.*.merchant_id' => 'nullable|numeric',
            'inventories.*.batch_id'    => 'nullable|numeric',
        ];
    }
}
