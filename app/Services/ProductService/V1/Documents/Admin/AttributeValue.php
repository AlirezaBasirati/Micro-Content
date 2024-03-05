<?php

namespace App\Services\ProductService\V1\Documents\Admin;

/**
 ** @OA\Get(
 *     path="/api/admin/v1/content/attribute-values",
 *     tags={"Admin | Attribute Value"},
 *     summary="List all Attribute Values",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/admin/v1/content/attribute-values",
 *     tags={"Admin | Attribute Value"},
 *     summary="Create a Attribute Value",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema(required={},
 *                   @OA\Property(
 *                      property="value",
 *                      type="string"
 *                  ),
 *                   @OA\Property(
 *                      property="name",
 *                      type="string"
 *                  ),
 *                   @OA\Property(
 *                      property="image",
 *                      type="file"
 *                  ),
 *                  @OA\Property(
 *                      property="attribute_id",
 *                      type="integer"
 *                  ),
 *                  example={"value": "first attribute value",
 *                  "attribute_id": 1}
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
 *     path="/api/admin/v1/content/attribute-values/{id}",
 *     tags={"Admin | Attribute Value"},
 *     summary="Find Attribute Value by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Attribute Value id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Patch(
 *     path="/api/admin/v1/content/attribute-values/{id}",
 *     tags={"Admin | Attribute Value"},
 *     summary="Update Attribute Value by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Attribute Value id",@OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  @OA\Property(
 *                      property="value",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="attribute_id",
 *                      type="integer"
 *                  ),
 *                  example={"value": "first attribute value",
 *                  "attribute_id": 1}
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
 *     path="/api/admin/v1/content/attribute-values/{id}",
 *     tags={"Admin | Attribute Value"},
 *     summary="Delete Attribute Value by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Attribute Value id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class AttributeValue
{

}
