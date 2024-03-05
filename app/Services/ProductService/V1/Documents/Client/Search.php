<?php

namespace App\Services\ProductService\V1\Documents\Client;

/**
 * @OA\Get(
 *     path="/api/app/v1/content/search",
 *     tags={"Client | Search"},
 *     summary="Search phrase",
 *     @OA\Parameter(name="query",in="query",description="search phrase ",@OA\Schema(type="array", @OA\Items(type="string"))),
 *     @OA\Parameter(name="store_id",in="query",description="filter by store id ",@OA\Schema(type="array", @OA\Items(type="integer"))),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/app/v1/content/search/recent",
 *     tags={"Client | Search"},
 *     summary="Find User Recent Searches",
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 *
 * @OA\Get(
 *     path="/api/app/v1/content/search/popular",
 *     tags={"Client | Search"},
 *     summary="Find Popular Searches",
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class Search
{

}
