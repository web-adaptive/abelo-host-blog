<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enums\HttpStatusCodeEnum;
use App\Http\Response;
use App\Logging\FileLogger;
use App\View\ViewRenderer;
use Throwable;

final class ExceptionHandler
{
    private Response $response;
    private ViewRenderer $view;
    private FileLogger $logger;

    public function __construct(
        Response $response,
        ViewRenderer $view,
        FileLogger $logger
    ) {
        $this->response = $response;
        $this->view = $view;
        $this->logger = $logger;
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

        $this->logger->error(sprintf(
            '%s in %s:%d',
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine()
        ));

        $content = $this->view->render($template, [
            'message' => $message,
            'status' => $status->value,
        ]);

        $this->response->html($content, $status);
    }
}
