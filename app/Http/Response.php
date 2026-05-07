<?php

declare(strict_types=1);

namespace App\Http;

use App\Enums\HttpStatusCodeEnum;

final class Response
{
    public function html(string $content, HttpStatusCodeEnum $status = HttpStatusCodeEnum::OK): void
    {
        http_response_code($status->value);
        echo $content;
    }
}
