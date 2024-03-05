<?php

namespace App\Services\ProductService\V1\Documents\Admin;

/**
 ** @OA\Get(
 *     path="/api/admin/v1/content/attributes",
 *     tags={"Admin | Attribute"},
 *     summary="List all Attributes",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/admin/v1/content/attributes",
 *     tags={"Admin | Attribute"},
 *     summary="Create a Attribute",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  @OA\Property(
 *                      property="title",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="slug",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="type",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="status",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="visible",
 *                      type="integer"
 *                  ),
 *                  example={"title": "first attribute", "slug": "main-attribute",
 *                  "type": "drop down","status": 1,
 *                  "visible": 1}
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
 *     path="/api/admin/v1/content/attributes/{id}",
 *     tags={"Admin | Attribute"},
 *     summary="Find Attribute by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Attribute id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Patch(
 *     path="/api/admin/v1/content/attributes/{id}",
 *     tags={"Admin | Attribute"},
 *     summary="Update Attribute by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Attribute id",@OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                   @OA\Property(
 *                      property="title",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="slug",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="type",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="status",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="visible",
 *                      type="integer"
 *                  ),
 *                  example={"title": "first attribute", "slug": "main-attribute",
 *                  "type": "drop down","status": 1,
 *                  "visible": 1}
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
 *     path="/api/admin/v1/content/attributes/{id}",
 *     tags={"Admin | Attribute"},
 *     summary="Delete Attribute by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Attribute id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class Attribute
{

}
