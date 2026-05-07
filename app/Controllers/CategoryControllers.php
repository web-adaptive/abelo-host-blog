<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Response;
use App\Services\CategoryService;
use App\View\ViewRenderer;

final class CategoryControllers extends BaseController
{
    public function __construct(
        ViewRenderer $view,
        Response $response,
        private readonly CategoryService $categoryService
    ) {
        parent::__construct($view, $response);
    }

    public function show(int $id): void
    {
        $category = $this->categoryService->getCategory($id);

        if ($category === null) {
            throw new NotFoundException('Category not found');
        }

        $this->render('category.tpl', [
            'title' => 'Категория',
            'category' => $category,
        ]);
    }
}
