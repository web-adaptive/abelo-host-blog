<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\HttpStatusCodeEnum;
use App\Http\Response;
use App\View\ViewRenderer;
use Throwable;

final class ExceptionHandler
{
    public function __construct(
        private readonly Response $response,
        private readonly ViewRenderer $view
    ) {
    }

    public function handle(Throwable $exception): void
    {
        $status = HttpStatusCodeEnum::INTERNAL_SERVER_ERROR;
        $message = 'Internal Server Error';
        $template = 'errors/500.tpl';

        if ($exception instanceof HttpException) {
            $status = $exception->statusCode();
            $message = $exception->getMessage();
            $template = $status === HttpStatusCodeEnum::NOT_FOUND ? 'errors/404.tpl' : 'errors/500.tpl';
        }

        $content = $this->view->render($template, [
            'message' => $message,
            'status' => $status->value,
        ]);

        $this->response->html($content, $status);
    }
}
