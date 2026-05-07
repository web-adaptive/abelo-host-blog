<?php

declare(strict_types=1);

namespace App\Http;

use App\Enums\HttpStatusCodeEnum;

/**
 * Объект HTTP-ответа.
 */
final class Response
{
    /**
     * Отправляет HTML с нужным статус-кодом.
     *
     * @param string $content Тело HTML-ответа.
     * @param HttpStatusCodeEnum $status HTTP-статус ответа.
     * @return void
     */
    public function html(string $content, HttpStatusCodeEnum $status = HttpStatusCodeEnum::OK): void
    {
        http_response_code($status->value);
        header('Content-Type: text/html; charset=UTF-8');
        echo $content;
    }
}
