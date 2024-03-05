<?php

namespace App\Services\ContentManagerService\V1\Documents\Admin;

/**
 *
 * @OA\Post(
 *     path="/api/admin/v1/content/slider-positions",
 *     tags={"Admin | Slider Position"},
 *     summary="Create a slider position",
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
 *                      type="integer"
 *                  ),
 *                  example={"title": "first position", "slug": "main-position"}
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
 *     path="/api/admin/v1/content/slider-positions",
 *     tags={"Admin | Slider Position"},
 *     summary="List all Slider Positions",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/content/slider-positions/{id}",
 *     tags={"Admin | Slider Position"},
 *     summary="Find Slider Position by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Slider Position id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Patch(
 *     path="/api/admin/v1/content/slider-positions/{id}",
 *     tags={"Admin | Slider Position"},
 *     summary="Update Slider Position by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Slider Position id",@OA\Schema(type="integer")),
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
 *                      type="integer"
 *                  ),
 *                  example={"title": "first position", "slug": "main-position"}
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
 *     path="/api/admin/v1/content/slider-positions/{id}",
 *     tags={"Admin | Slider Position"},
 *     summary="Delete Slider Position by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Slider Position id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 */
class SliderPosition
{

}
