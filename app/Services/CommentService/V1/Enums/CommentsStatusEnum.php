<?php

namespace App\Services\CommentService\V1\Enums;

Enum CommentsStatusEnum: int
{
    case NOT_APPROVED = 0;
    case APPROVED = 1;
    case JUNK = 2;
}
