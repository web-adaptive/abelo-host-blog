<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\SeedService;
use App\View\ViewRenderer;

/**
 * Контроллер ручного запуска сидирования.
 */
final class SeedControllers extends BaseController
{
    private SeedService $seedService;

    public function __construct(
        ViewRenderer $view,
        Response $response,
        SeedService $seedService
    ) {
        parent::__construct($view, $response);
        $this->seedService = $seedService;
    }

    /**
     * Выполняет сидирование и рендерит страницу результата.
     *
     * @param Request $request HTTP-запрос.
     * @return void
     */
    public function run(Request $request): void
    {
        $result = $this->seedService->run();

        $this->render('seed-result.tpl', [
            'title' => 'Seeding completed',
            'result' => $result,
        ]);
    }
}
