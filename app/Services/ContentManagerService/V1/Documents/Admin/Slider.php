<?php

namespace App\Services\ContentManagerService\V1\Documents\Admin;

/**
 *
 * @OA\Post(
 *     path="/api/admin/v1/content/sliders",
 *     tags={"Admin | Slider"},
 *     summary="Create a slider",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *               @OA\Schema(required={"title","slider_id"},
 *                   @OA\Property(
 *                       property="title",
 *                       type="string"
 *                   ),
 *                   @OA\Property(
 *                       property="type",
 *                       type="string"
 *                   ),
 *                   @OA\Property(
 *                       property="position_id",
 *                       type="integer"
 *                   ),
 *                   @OA\Property(
 *                       property="status",
 *                       type="integer"
 *                   ),
 *                   @OA\Property(
 *                       property="height",
 *                       type="integer"
 *                   ),
 *                   @OA\Property(
 *                       property="width",
 *                       type="integer"
 *                   ),
 *                  example={"title": "main", "type": "main", "position_id": 1, "status": 1, "height" : 200, "width": 300}
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
 *     path="/api/admin/v1/content/sliders",
 *     tags={"Admin | Slider"},
 *     summary="List all Sliders",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/admin/v1/content/sliders/{id}",
 *     tags={"Admin | Slider"},
 *     summary="Find Slider by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Slider id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Patch(
 *     path="/api/admin/v1/content/sliders/{id}",
 *     tags={"Admin | Slider"},
 *     summary="Update Slider by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Slider id",@OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *                @OA\Schema(required={},
 *                   @OA\Property(
 *                       property="title",
 *                       type="string"
 *                   ),
 *                   @OA\Property(
 *                       property="type",
 *                       type="string"
 *                   ),
 *                   @OA\Property(
 *                       property="position_id",
 *                       type="integer"
 *                   ),
 *                   @OA\Property(
 *                       property="status",
 *                       type="integer"
 *                   ),
 *                   @OA\Property(
 *                       property="height",
 *                       type="integer"
 *                   ),
 *                   @OA\Property(
 *                       property="width",
 *                       type="integer"
 *                   ),
 *                  example={"title": "main", "type": "main", "position_id": 1, "status": 1, "height" : 200, "width": 300}
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
 *     path="/api/admin/v1/content/sliders/{id}",
 *     tags={"Admin | Slider"},
 *     summary="Delete Slider by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Slider id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 */
class Slider
{

}
