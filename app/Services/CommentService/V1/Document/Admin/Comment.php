<?php

namespace App\Services\CommentService\V1\Document\Admin;

/**
 * @OA\Get(
 *     path="/api/admin/v1/content/comments",
 *     tags={"Admin | Comment"},
 *     summary="List all Comments",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Patch(
 *     path="/api/admin/v1/content/comments/{id}",
 *     tags={"Admin | Comment"},
 *     summary="Update Comment by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Comment id",@OA\Schema(type="integer")),
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                   @OA\Property(
 *                      property="status",
 *                      type="integer"
 *                  ),
 *                  example={"status": 1}
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
 *     path="/api/admin/v1/content/comments/{id}",
 *     tags={"Admin | Comment"},
 *     summary="Delete Comment by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Comment id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class Comment
{

}
