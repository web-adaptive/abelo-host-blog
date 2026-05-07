<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\SeedService;
use App\View\ViewRenderer;

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

    public function run(Request $request): void
    {
        $result = $this->seedService->run();

        $this->render('seed-result.tpl', [
            'title' => 'Seeding completed',
            'result' => $result,
        ]);
    }
}
