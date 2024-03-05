<?php

namespace App\Services\FavoriteService\V1\Document\Client;

/**
 * @OA\Get(
 *     path="/api/client/v1/content/favorites",
 *     tags={"Client | Favorite"},
 *     summary="List all Favorites",
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * * @OA\Get(
 *     path="/api/client/v1/content/favorites/is-favorite",
 *     tags={"Client | Favorite"},
 *     summary="Is Product In Favorites",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *           @OA\MediaType(
 *               mediaType="application/json",
 *               @OA\Schema(required={},
 *                   @OA\Property(
 *                       property="product_id",
 *                       type="integer"
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
 * @OA\Post(
 *     path="/api/client/v1/content/favorites",
 *     tags={"Client | Favorite"},
 *     summary="Create a Favorite",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *          @OA\MediaType(
 *              mediaType="application/json",
 *              @OA\Schema(required={},
 *                  @OA\Property(
 *                      property="user_id",
 *                      type="integer"
 *                  ),
 *                  @OA\Property(
 *                      property="product_id",
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
 *     path="/api/client/v1/content/favorites",
 *     tags={"Client | Favorite"},
 *     summary="Delete Favorite by id",
 *     security={{"bearerAuth":{}}},
 *     @OA\RequestBody(required=true,
 *           @OA\MediaType(
 *               mediaType="application/json",
 *               @OA\Schema(required={},
 *                   @OA\Property(
 *                       property="product_id",
 *                       type="integer"
 *                   ),
 *               )
 *           )
 *      ),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class Favorite
{

}
