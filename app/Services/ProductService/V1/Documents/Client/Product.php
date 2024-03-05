<?php

namespace App\Services\ProductService\V1\Documents\Client;

/**
 * @OA\Get(
 *     path="/api/app/v1/content/flat-products",
 *     tags={"Client | Product"},
 *     summary="List all Products",
 *     @OA\Parameter(name="category_ids",in="query",description="filter by category id ",@OA\Schema(type="array", @OA\Items(type="integer"))),
 *     @OA\Parameter(name="store_ids",in="query",description="filter by store id ",@OA\Schema(type="array", @OA\Items(type="integer"))),
 *     @OA\Parameter(name="status",in="query",description="filter by status ",@OA\Schema(type="integer")),
 *     @OA\Parameter(name="paginate",in="query",description="paginate ",@OA\Schema(type="integer")),
 *     @OA\Parameter(name="group_by",in="query",description="group by category title ",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 * @OA\Get(
 *     path="/api/app/v1/content/flat-products/filters",
 *     tags={"Client | Product"},
 *     summary="filters all Products",
 *     @OA\Parameter(name="category_ids",in="query",description="filter by category id ",@OA\Schema(type="array", @OA\Items(type="integer"))),
 *     @OA\Parameter(name="store_ids",in="query",description="filter by store id ",@OA\Schema(type="array", @OA\Items(type="integer"))),
 *     @OA\Parameter(name="brand_ids",in="query",description="filter by store id ",@OA\Schema(type="array", @OA\Items(type="integer"))),
 *     @OA\Parameter(name="status",in="query",description="filter by status ",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 * @OA\Get(
 *     path="/api/app/v1/content/flat-products/leach",
 *     tags={"Client | Product"},
 *     summary="filters all Products",
 *     @OA\Parameter(name="category_ids",in="query",description="filter by category id ",@OA\Schema(type="array", @OA\Items(type="integer"))),
 *     @OA\Parameter(name="store_ids",in="query",description="filter by store id ",@OA\Schema(type="array", @OA\Items(type="integer"))),
 *     @OA\Parameter(name="brand_ids",in="query",description="filter by store id ",@OA\Schema(type="array", @OA\Items(type="integer"))),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/app/v1/content/flat-products/fetch",
 *     tags={"Client | Product"},
 *     summary="Filter Product",
 *     @OA\Parameter(name="sku",in="query",description="filter by sku ",@OA\Schema(type="string")),
 *     @OA\Parameter(name="store_id",in="query",description="filter by store ",@OA\Schema(type="string")),
 *     @OA\Parameter(name="merchant_id",in="query",description="filter by merchant ",@OA\Schema(type="string")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/app/v1/content/flat-products/{sku}",
 *     tags={"Client | Product"},
 *     summary="Find Product by id",
 *     @OA\Parameter(name="sku",in="path",description="Product id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class Product
{

}
