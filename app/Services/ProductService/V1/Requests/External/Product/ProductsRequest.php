<?php

namespace App\Services\ProductService\V1\Requests\External\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
{
    public function rules(): array
    {
        $this->merge(['data' => $this->all()]);
        return [
            'data'                          => ['required', 'array'],
            'data.*.SKU'                    => 'required',
            'data.*.DESCRIPTION'            => 'required',
            'data.*.BARCODE'                => 'required',
            'data.*.PUBLIC_ID'              => 'required',
            'data.*.TAX'                    => 'required',
            'data.*.WEIGHT'                 => 'required',
            'data.*.BASE_UNIT'              => 'required',
            'data.*.SUB_UNIT'               => 'required',
            'data.*.NUMBER_OF_UNIT_MEASURE' => 'required',
            'data.*.WIDTH'                  => 'required',
            'data.*.HEIGHT'                 => 'required',
            'data.*.LENGTH'                 => 'required',
            'data.*.TRANSACTIONID'          => 'required',
        ];
    }
}
