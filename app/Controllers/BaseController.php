<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Enums\HttpStatusCodeEnum;
use App\Http\Response;
use App\View\ViewRenderer;

abstract class BaseController
{
    public function __construct(
        protected readonly ViewRenderer $view,
        protected readonly Response $response
    ) {
    }

    protected function render(string $template, array $data = [], HttpStatusCodeEnum $status = HttpStatusCodeEnum::OK): void
    {
        $this->response->html($this->view->render($template, $data), $status);
    }
}
