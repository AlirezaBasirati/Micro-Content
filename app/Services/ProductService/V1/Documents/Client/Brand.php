<?php

namespace App\Services\ProductService\V1\Documents\Client;

/**
 * @OA\Get(
 *     path="/api/app/v1/content/brands",
 *     tags={"Client | Brand"},
 *     summary="List all Brands",
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/app/v1/content/brands/{id}",
 *     tags={"Client | Brand"},
 *     summary="Find Brand by id",
 *     @OA\Parameter(name="id",in="path",description="Brand id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/app/v1/content/brands/{id}/products",
 *     tags={"Client | Brand"},
 *     summary="Find Products Assigned To Brand",
 *     @OA\Parameter(name="id",in="path",description="Brand id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class Brand
{

}
