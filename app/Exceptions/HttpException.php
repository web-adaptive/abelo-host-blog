<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\HttpStatusCodeEnum;
use RuntimeException;

class HttpException extends RuntimeException
{
    public function __construct(
        private readonly HttpStatusCodeEnum $statusCode,
        string $message
    ) {
        parent::__construct($message, $statusCode->value);
    }

    public function statusCode(): HttpStatusCodeEnum
    {
        return $this->statusCode;
    }
}
