<?php

namespace App\Services\ProductService\V1\Documents\Admin;

/**
 *
 * @OA\Post(
 *     path="/api/admin/v1/content/categories",
 *     tags={"Admin | Category"},
 *     summary="Create a Category",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema(required={"title","parent_id","slug","visible_in_menu"},
 *                  @OA\Property(
 *                      property="title",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="parent_id",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="slug",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="icon",
 *                      type="file"
 *                  ),
 *                  @OA\Property(
 *                      property="image",
 *                      type="file"
 *                  ),
 *                  @OA\Property(
 *                      property="description",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="status",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="level",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="position",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="visible_in_menu",
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
 *     path="/api/admin/v1/content/categories",
 *     tags={"Admin | Category"},
 *     summary="List all Categories",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/content/categories/{id}",
 *     tags={"Admin | Category"},
 *     summary="Find Category by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Category id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/admin/v1/content/categories/{id}",
 *     tags={"Admin | Category"},
 *     summary="Update Category by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Category id",@OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema(required={},
 *                   @OA\Property(
 *                      property="title",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="parent_id",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="slug",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="icon",
 *                      type="file"
 *                  ),
 *                  @OA\Property(
 *                      property="image",
 *                      type="file"
 *                  ),
 *                  @OA\Property(
 *                      property="description",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="status",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="level",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="position",
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
 *     path="/api/admin/v1/content/categories/{id}",
 *     tags={"Admin | Category"},
 *     summary="Delete Category by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Category id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/content/categories/{id}/children",
 *     tags={"Admin | Category"},
 *     summary="Find Category Children by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Category id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/content/categories/{id}/nested",
 *     tags={"Admin | Category"},
 *     summary="Find Category Nested by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Category id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/content/categories/{id}/breadcrumb",
 *     tags={"Admin | Category"},
 *     summary="Find Category Breadcrumb by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Category id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/content/categories/{id}/products",
 *     tags={"Admin | Category"},
 *     summary="Get All Products IN Category",
 *     security={{"bearerAuth":{}}},
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
