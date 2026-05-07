<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\HttpStatusCodeEnum;

/**
 * Исключение для неподдерживаемого HTTP-метода.
 */
final class MethodNotAllowedException extends HttpException
{
    public function __construct(string $message = 'Method Not Allowed')
    {
        parent::__construct(HttpStatusCodeEnum::METHOD_NOT_ALLOWED, $message);
    }
}
