<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\HttpStatusCodeEnum;

final class NotFoundException extends HttpException
{
    public function __construct(string $message = 'Page not found')
    {
        parent::__construct(HttpStatusCodeEnum::NOT_FOUND, $message);
    }
}
