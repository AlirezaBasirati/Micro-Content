<?php

namespace App\Services\ContentManagerService\V1\Documents\Client;

/**
 * @OA\Get(
 *     path="/api/app/v1/content/slider-positions/{slug}",
 *     tags={"Client | Slider Position"},
 *     summary="Find Slider Position by slug",
 *     @OA\Parameter(name="slug",in="path",description="Slider Position slug",@OA\Schema(type="string")),
 *     @OA\Response(
 *         response=200,
 *         description="OK"
 *     )
 * )
 */
class SliderPosition
{

}
