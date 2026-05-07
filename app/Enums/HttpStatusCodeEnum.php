<?php

declare(strict_types=1);

namespace App\Enums;

enum HttpStatusCodeEnum: int
{
    case OK = 200;
    case NOT_FOUND = 404;
    case METHOD_NOT_ALLOWED = 405;
    case INTERNAL_SERVER_ERROR = 500;
}
