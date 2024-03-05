<?php

use App\Services\ProductService\V1\Enumerations\Attribute\Attribute;
use App\Services\ProductService\V1\Models\AttributeValue;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('testt', function () {

//    $isConfigurable = \App\Services\ProductService\V1\Models\AttributeValue::query()
//        ->whereIn('id', [1,2,3,4])
//        ->groupBy('attribute_id')
//        ->selectRaw('attribute_id, count(attribute_id) as count')
//        ->having('count', '>', 1)
//        ->exists();
//
//    dd($isConfigurable);


    $attributes = \App\Services\ProductService\V1\Models\AttributeValue::query()
        ->whereIn('id', [1,3,7,8,4,5,6])
        ->select('id as attribute_value_id', 'attribute_id')
        ->get()
        ->groupBy('attribute_id')
        ->toArray();

//    dd($attributes);
//
//
//
//
//    $attributes = [
//        ['yellow', 'red', 'blue'],
//        ['s', 'm', 'l', 'xl'],
//        ['x', 'y']
//    ];

    $products = [];

    foreach (array_shift($attributes) as $attribute_value) {
        $products[] = [$attribute_value];
    }

    foreach ($attributes as $attribute_values) {
        $temp_products = [];

        foreach ($attribute_values as $attribute_value) {
            foreach ($products as $product) {
                $temp_products[] = array_merge((array) $product, [$attribute_value]);
            }
        }

        $products = $temp_products;
    }

    dd($products);
    return $products;

});
function x(array $a, $b = [])
{
    $c = [];
    if (count($a) > 1) {
        $current = array_shift($a);
        foreach ($current as $item) {
            x($a, array_merge($b, $item));
        }
    }
    else {
        foreach ($a as $item) {
            $c[] = array_merge($b, $item);
        }
    }
    return $c;
}

Artisan::command('testtt', function () {

    $a = [
        1 => [3,2,4],
        2 => [13,12],
        3 => [7,8,9,10],
    ];

    dd(x($a));

    $a = array_map(fn($r) => count($r), $a);

    $v = 1;
    $g = [];

    foreach ($a as $k => $z) {

        $g[$z] =$v;

        $v *= $z;
    }

    for ($i = 0 ; array_product($a) > $i; $i++) {
        $product = null;
        foreach ($g as $y => $x) {
            $product = $a[($i / $x ) % $y];
        }
        dd($product);
//        dump(sprintf("%d %d %d", ($i / 1 ) % $z, ($i/3) % 2, ($i / 6) % 4));
    }


});
