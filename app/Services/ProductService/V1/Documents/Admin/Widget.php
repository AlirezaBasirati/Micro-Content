<?php

namespace App\Services\ProductService\V1\Documents\Admin;

/**
 * @OA\Get(
 *     path="/api/admin/v1/content/widgets",
 *     tags={"Admin | Widget"},
 *     summary="List all Widgets",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/admin/v1/content/widgets",
 *     tags={"Admin | Widget"},
 *     summary="Create a Widget",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={"name": "recommendation", "slug": "recommendation"}
 *              )
 *          )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/content/widgets/{slug}",
 *     tags={"Admin | Widget"},
 *     summary="Find Widget by slug",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="slug",in="path",description="Widget slug",@OA\Schema(type="string")),
 *     @OA\Parameter(name="store_id",in="query",description="Store id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Patch(
 *     path="/api/admin/v1/content/widgets/{slug}",
 *     tags={"Admin | Widget"},
 *     summary="Update Widget by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="slug",in="path",description="Widget slug",@OA\Schema(type="string")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  example={"name": "recommendation", "slug": "recommendation"}
 *              )
 *          )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Delete(
 *     path="/api/admin/v1/content/widgets/{slug}",
 *     tags={"Admin | Widget"},
 *     summary="Delete Widget by slug",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="slug",in="path",description="Widget slug",@OA\Schema(type="string")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *      path="/api/admin/v1/content/widgets/{slug}/product/assign",
 *      tags={"Admin | Widget"},
 *      summary="Create Configurable Widget",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="slug",in="path",description="Widget slug",@OA\Schema(type="string")),
 *      @OA\RequestBody(required=true,
 *           @OA\MediaType(
 *               mediaType="application/json",
 *               @OA\Schema(required={},
 *                    @OA\Property(
 *                       property="product_ids",
 *                       type="array",
 *                            @OA\Items(
 *                                 type="integer",
 *                            ),
 *                        example={3,5}
 *                   )
 *               )
 *           )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 * @OA\Post(
 *      path="/api/admin/v1/content/widgets/{slug}/product/unassign",
 *      tags={"Admin | Widget"},
 *      summary="Create Configurable Widget",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="slug",in="path",description="Widget slug",@OA\Schema(type="string")),
 *      @OA\RequestBody(required=true,
 *           @OA\MediaType(
 *               mediaType="application/json",
 *               @OA\Schema(required={},
 *                    @OA\Property(
 *                       property="product_ids",
 *                       type="array",
 *                            @OA\Items(
 *                                 type="integer",
 *                            ),
 *                        example={3,5}
 *                   )
 *               )
 *           )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 */
class Widget
{

}
