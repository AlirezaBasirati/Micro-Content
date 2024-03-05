<?php

namespace App\Services\CommentService\V1\Enums;

enum IsRecommendedStatus: int
{
    case NO_IDEA = 0;
    case I_RECOMMEND = 1;
    case I_DONT_RECOMMEND = 2;
}
