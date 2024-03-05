<?php

namespace App\Services\ProductService\V1\Documents\Client;

/**
 * @OA\Get(
 *     path="/api/app/v1/content/categories/{id}/children",
 *     tags={"Client | Category"},
 *     summary="Find Category Children by id",
 *     @OA\Parameter(name="id",in="path",description="Category id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *  * * @OA\Get(
 *     path="/api/app/v1/content/categories/{id}/nested",
 *     tags={"Client | Category"},
 *     summary="Find Category Nested by id",
 *     @OA\Parameter(name="id",in="path",description="Category id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 *  * * @OA\Get(
 *     path="/api/app/v1/content/categories/{id}/breadcrumb",
 *     tags={"Client | Category"},
 *     summary="Find Category Breadcrumb by id",
 *     @OA\Parameter(name="id",in="path",description="Category id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class Category
{

}
