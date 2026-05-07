<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\CategoryService;
use App\View\ViewRenderer;

final class HomeControllers extends BaseController
{
    public function __construct(
        ViewRenderer $view,
        Response $response,
        private readonly CategoryService $categoryService
    ) {
        parent::__construct($view, $response);
    }

    public function index(Request $request): void
    {
        $categories = $this->categoryService->getHomeCategoriesWithPosts(3);

        $this->render('home.tpl', [
            'title' => 'Главная страница',
            'categories' => $categories,
        ]);
    }
}
