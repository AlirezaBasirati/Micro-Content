<?php

namespace App\Services\ProductService\V1\Documents\Admin;

/**
 * @OA\Get(
 *     path="/api/admin/v1/content/products",
 *     tags={"Admin | Product"},
 *     summary="List all Products",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="category_id",in="query",description="Category id",@OA\Schema(type="integer")),
 *     @OA\Parameter(name="brand_id",in="query",description="Brand id",@OA\Schema(type="integer")),
 *     @OA\Parameter(name="search",in="query",description="By name OR sku",@OA\Schema(type="string")),
 *     @OA\Parameter(name="page",in="query",description="Page number",@OA\Schema(type="integer")),
 *     @OA\Parameter(name="paginate",in="query",description="Paginate",@OA\Schema(type="boolean")),
 *     @OA\Parameter(name="per_page",in="query",description="Per Page number",@OA\Schema(type="integer")),
 *     @OA\Parameter(name="sort_by",in="query",description="Sort By",@OA\Schema(type="string")),
 *     @OA\Parameter(name="sort_direction",in="query",description="sort direction",@OA\Schema(type="string")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/admin/v1/content/products",
 *     tags={"Admin | Product"},
 *     summary="Create a Product",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                   @OA\Property(
 *                      property="name",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="public_id",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="url_key",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="tax_class",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="sku",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="brand_id",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="status",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="visibility",
 *                      type="integer"
 *                  ),
 *                  example={"name": "first product", "sku": "asdd",
 *                  "public_id": "asdd","url_key": "asdd","tax_class": 9,
 *                  "brand_id": 1,"status": 1,
 *                  "visibility": 1}
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
 *     path="/api/admin/v1/content/products/{id}",
 *     tags={"Admin | Product"},
 *     summary="Find Product by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Product id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/content/products/export",
 *     tags={"Admin | Product"},
 *     summary="Export Products",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="category_id",in="query",description="Category id",@OA\Schema(type="integer")),
 *     @OA\Parameter(name="brand_id",in="query",description="Brand id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Patch(
 *     path="/api/admin/v1/content/products/{id}",
 *     tags={"Admin | Product"},
 *     summary="Update Product by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Product id",@OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  @OA\Property(
 *                      property="name",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="sku",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="brand_id",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="status",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="visibility",
 *                      type="integer"
 *                  ),
 *                  example={"name": "first product", "sku": "asdd",
 *                  "brand_id": 1,"status": 1,
 *                  "visibility": 1}
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
 *     path="/api/admin/v1/content/products/{id}",
 *     tags={"Admin | Product"},
 *     summary="Delete Product by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Product id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/admin/v1/content/products/{id}/product-values/{attributeValue}",
 *     tags={"Admin | Product"},
 *     summary="Assign Attribute Value To Product",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Product id",@OA\Schema(type="integer")),
 *     @OA\Parameter(name="attributeValue",in="path",description="Attribute Value Id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Delete (
 *     path="/api/admin/v1/content/products/{id}/product-values/{attributeValue}",
 *     tags={"Admin | Product"},
 *     summary="Unassign Attribute Value From product",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Product id",@OA\Schema(type="integer")),
 *     @OA\Parameter(name="attributeValue",in="path",description="Attribute Value Id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/admin/v1/content/products/extended",
 *     tags={"Admin | Product"},
 *     summary="Extended Create a Product",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="X-Consumer-ID",in="header",description="authenticate user",@OA\Schema(type="string")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema(required={},
 *                   @OA\Property(
 *                      property="name",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="public_id",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="url_key",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="tax_class",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="sku",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="brand_id",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="status",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="visibility",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="max_in_cart",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="min_in_cart",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="thumbnail",
 *                      type="file"
 *                  ),
 *                  @OA\Property(
 *                      property="categories",
 *                      type="array",
 *                           @OA\Items(
 *                                type="integer",
 *                           ),
 *                  ),
 *                  @OA\Property(
 *                      property="images",
 *                      type="array",
 *                           @OA\Items(
 *                                type="file",
 *                           ),
 *                  ),
 *                   @OA\Property(
 *                       property="attribute_value_ids",
 *                       type="array",
 *                            @OA\Items(
 *                                 type="integer",
 *                            ),
 *                   ),
 *              )
 *          )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/admin/v1/content/products/{id}/extended",
 *     tags={"Admin | Product"},
 *     summary="Extended Update a Product",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Product id",@OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema(required={},
 *                   @OA\Property(
 *                      property="name",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="public_id",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="url_key",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="tax_class",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="sku",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="brand_id",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="status",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="visibility",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="max_in_cart",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="min_in_cart",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="thumbnail",
 *                      type="file"
 *                  ),
 *                  @OA\Property(
 *                      property="categories",
 *                      type="array",
 *                           @OA\Items(
 *                                type="integer",
 *                           ),
 *                  ),
 *                  @OA\Property(
 *                      property="delete_images",
 *                      type="array",
 *                           @OA\Items(
 *                                type="integer",
 *                           ),
 *                  ),
 *                  @OA\Property(
 *                      property="images",
 *                      type="array",
 *                           @OA\Items(
 *                                type="file",
 *                           ),
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
 * @OA\Post(
 *     path="/api/admin/v1/content/products/{id}/product-image",
 *     tags={"Admin | Product"},
 *     summary="Add Image To Product",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Product id",@OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema(required={},
 *                   @OA\Property(
 *                      property="image",
 *                      type="file"
 *                  )
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
 *     path="/api/admin/v1/content/products/{id}/product-image/{productImage}",
 *     tags={"Admin | Product"},
 *     summary="Unassign Attribute Value From product",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Product id",@OA\Schema(type="integer")),
 *     @OA\Parameter(name="productImage",in="path",description="Product Image Id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/admin/v1/content/products/{id}/category/assign",
 *     tags={"Admin | Product"},
 *     summary="Assign Categories To Product",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Product id",@OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                   @OA\Property(
 *                      property="category_ids",
 *                      type="array",
 *                           @OA\Items(
 *                                type="integer",
 *                           ),
 *                       example={3,5}
 *                  )
 *              )
 *          )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/admin/v1/content/products/{id}/category/unassign",
 *     tags={"Admin | Product"},
 *     summary="Unassign Categories To Product",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Product id",@OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                   @OA\Property(
 *                      property="category_ids",
 *                      type="array",
 *                           @OA\Items(
 *                                type="integer",
 *                           ),
 *                       example={3,5}
 *                  )
 *              )
 *          )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/admin/v1/content/products/categories",
 *     tags={"Admin | Product"},
 *     summary="Bulk Assign Products To Categories",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                   @OA\Property(
 *                      property="category_ids",
 *                      type="array",
 *                           @OA\Items(
 *                                type="integer",
 *                           ),
 *                       example={3,5}
 *                  ),
 *                      @OA\Property(
 *                      property="detach",
 *                      type="boolean"
 *                  ),
 *                   @OA\Property(
 *                      property="filters",
 *                      type="array",
 *                           @OA\Items(
 *                                type="integer",
 *                           ),
 *                       example={"category_ids": {4,8},
 *                                  "brand_id": 1,
 *                                  "product_ids": {1},
 *                                  "except":{45,56}}
 *                  )
 *              )
 *          )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *      path="/api/admin/v1/content/products/{id}/configurable",
 *      tags={"Admin | Product"},
 *      summary="Create Configurable Product",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="id",in="path",description="Product id",@OA\Schema(type="integer")),
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
 *      path="/api/admin/v1/content/products/{id}/configurable/remove",
 *      tags={"Admin | Product"},
 *      summary="Create Configurable Product",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="id",in="path",description="Product id",@OA\Schema(type="integer")),
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
 *      path="/api/admin/v1/content/products/import",
 *      tags={"Admin | Product"},
 *      summary="Create Product with Excel",
 *      security={{"bearerAuth":{}}},
 *      @OA\RequestBody(required=true,
 *           @OA\MediaType(
 *               mediaType="multipart/form-data",
 *               @OA\Schema(required={},
 *                    @OA\Property(
 *                       property="file",
 *                       type="file"
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
class Product
{

}
