<?php

namespace App\Services\ProductService\V1\Documents\Admin;

/**
 ** @OA\Get(
 *     path="/api/admin/v1/content/brands",
 *     tags={"Admin | Brand"},
 *     summary="List all Brands",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/admin/v1/content/brands",
 *     tags={"Admin | Brand"},
 *     summary="Create a Brand",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema(required={"name","slug"},
 *                  @OA\Property(
 *                      property="name",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="slug",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="description",
 *                      type="string",
 *                  ),
 *                  @OA\Property(
 *                      property="manufactured_in",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="en_name",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="thumbnail",
 *                      type="file"
 *                  ),
 *                  @OA\Property(
 *                      property="image",
 *                      type="file"
 *                  ),
 *                  @OA\Property(
 *                      property="status",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="is_featured",
 *                      type="integer"
 *                  ),
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
 *     path="/api/admin/v1/content/brands/{id}",
 *     tags={"Admin | Brand"},
 *     summary="Find Brand by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Brand id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/admin/v1/content/brands/{id}",
 *     tags={"Admin | Brand"},
 *     summary="Update Brand by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Brand id",@OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema(required={},
 *                  @OA\Property(
 *                      property="name",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="slug",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="description",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="manufactured_in",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="en_name",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="thumbnail",
 *                      type="file"
 *                  ),
 *                  @OA\Property(
 *                      property="image",
 *                      type="file"
 *                  ),
 *                  @OA\Property(
 *                      property="status",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="is_featured",
 *                      type="integer"
 *                  ),
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
 *     path="/api/admin/v1/content/brands/{id}",
 *     tags={"Admin | Brand"},
 *     summary="Delete Brand by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Brand id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/content/brands/{id}/products",
 *     tags={"Admin | Brand"},
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
