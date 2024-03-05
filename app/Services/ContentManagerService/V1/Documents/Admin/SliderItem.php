<?php

namespace App\Services\ContentManagerService\V1\Documents\Admin;

/**
 *
 * @OA\Post(
 *     path="/api/admin/v1/content/slider-items",
 *     tags={"Admin | Slider Item"},
 *     summary="Create a slider item",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *               mediaType="multipart/form-data",
 *               @OA\Schema(required={"title","slider_id"},
 *                   @OA\Property(
 *                       property="title",
 *                       type="string"
 *                   ),
 *                   @OA\Property(
 *                       property="url",
 *                       type="string"
 *                   ),
 *                   @OA\Property(
 *                       property="slider_id",
 *                       type="integer"
 *                   ),
 *                   @OA\Property(
 *                       property="status",
 *                       type="integer"
 *                   ),
 *                   @OA\Property(
 *                       property="image",
 *                       type="file"
 *                   ),
 *               )
 *           )
 *      ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/content/slider-items",
 *     tags={"Admin | Slider Item"},
 *     summary="List all Slider Items",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/content/slider-items/{id}",
 *     tags={"Admin | Slider Item"},
 *     summary="Find Slider Item by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Slider Item id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Patch(
 *     path="/api/admin/v1/content/slider-items/{id}",
 *     tags={"Admin | Slider Item"},
 *     summary="Update Slider Item by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Slider Item id",@OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *                mediaType="multipart/form-data",
 *                @OA\Schema(required={},
 *                    @OA\Property(
 *                        property="title",
 *                        type="string"
 *                    ),
 *                    @OA\Property(
 *                        property="url",
 *                        type="string"
 *                    ),
 *                    @OA\Property(
 *                        property="slider_id",
 *                        type="integer"
 *                    ),
 *                    @OA\Property(
 *                        property="status",
 *                        type="integer"
 *                    ),
 *                    @OA\Property(
 *                        property="image",
 *                        type="file"
 *                    ),
 *                )
 *            )
 *       ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Delete(
 *     path="/api/admin/v1/content/slider-items/{id}",
 *     tags={"Admin | Slider Item"},
 *     summary="Delete Slider Item by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Slider Item id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 */
class SliderItem
{

}
