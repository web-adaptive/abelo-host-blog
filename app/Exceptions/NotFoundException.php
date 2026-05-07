<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\HttpStatusCodeEnum;

/**
 * Исключение для ситуации "ресурс не найден".
 */
final class NotFoundException extends HttpException
{
    public function __construct(string $message = 'Page not found')
    {
        parent::__construct(HttpStatusCodeEnum::NOT_FOUND, $message);
    }
}
