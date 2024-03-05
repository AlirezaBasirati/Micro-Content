<?php

namespace App\Services\CommentService\V1\Document\Client;

/**
 * @OA\Get(
 *     path="/api/app/v1/content/comments",
 *     tags={"Client | Comment"},
 *     summary="List all Comments",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Post(
 *     path="/api/app/v1/content/comments",
 *     tags={"Client | Comment"},
 *     summary="Create a Comment",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  @OA\Property(
 *                      property="full_name",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="title",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="body",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="status",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="user_id",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="parent_id",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="product_id",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="positive_points",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="negative_points",
 *                      type="string"
 *                  ),
 *                  @OA\Property(
 *                      property="rate",
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
 *     path="/api/app/v1/content/comments/{id}",
 *     tags={"Client | Comment"},
 *     summary="Delete Comment by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(name="id",in="path",description="Comment id",@OA\Schema(type="integer")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Patch(
 *      path="/api/app/v1/content/comments/{id}/score",
 *      tags={"Client | Comment"},
 *      summary="Create Score For Comment",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="id",in="path",description="Comment id",@OA\Schema(type="integer")),
 *      @OA\RequestBody(required=true,
 *           @OA\MediaType(
 *               mediaType="application/json",
 *               @OA\Schema(required={},
 *                    @OA\Property(
 *                       property="score",
 *                       type="integer"
 *                   ),
 *                   example={"score": 1}
 *               )
 *           )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 *
 * @OA\Patch(
 *      path="/api/app/v1/content/comments/{id}/recommendation",
 *      tags={"Client | Comment"},
 *      summary="Create Recommendation For Comment",
 *      security={{"bearerAuth":{}}},
 *      @OA\Parameter(name="id",in="path",description="Comment id",@OA\Schema(type="integer")),
 *      @OA\RequestBody(required=true,
 *           @OA\MediaType(
 *               mediaType="application/json",
 *               @OA\Schema(required={},
 *                    @OA\Property(
 *                       property="status",
 *                       type="integer"
 *                   ),
 *                   example={"status": 1}
 *               )
 *           )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="OK"
 *      )
 *  )
 */
class Comment
{

}
