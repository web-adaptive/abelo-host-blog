<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\HttpStatusCodeEnum;
use RuntimeException;

/**
 * Базовое HTTP-исключение с кодом ответа.
 */
class HttpException extends RuntimeException
{
    public function __construct(
        private readonly HttpStatusCodeEnum $statusCode,
        string $message
    ) {
        parent::__construct($message, $statusCode->value);
    }

    /**
     * Возвращает HTTP-статус исключения.
     *
     * @return HttpStatusCodeEnum
     */
    public function statusCode(): HttpStatusCodeEnum
    {
        return $this->statusCode;
    }
}
