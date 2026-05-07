<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Enums\HttpStatusCodeEnum;
use App\Http\Response;
use App\View\ViewRenderer;

/**
 * Базовый контроллер с общим методом рендера.
 */
abstract class BaseController
{
    public function __construct(
        protected readonly ViewRenderer $view,
        protected readonly Response $response
    ) {
    }

    /**
     * Рендерит Smarty-шаблон и отправляет HTML-ответ.
     *
     * @param string $template Имя шаблона.
     * @param array<string, mixed> $data Данные шаблона.
     * @param HttpStatusCodeEnum $status HTTP-статус ответа.
     * @return void
     */
    protected function render(string $template, array $data = [], HttpStatusCodeEnum $status = HttpStatusCodeEnum::OK): void
    {
        $this->response->html($this->view->render($template, $data), $status);
    }
}
