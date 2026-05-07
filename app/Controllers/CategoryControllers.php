<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Request;
use App\Http\Response;
use App\Services\CategoryService;
use App\Services\PostService;
use App\View\ViewRenderer;

final class CategoryControllers extends BaseController
{
    private CategoryService $categoryService;
    private PostService $postService;

    public function __construct(
        ViewRenderer $view,
        Response $response,
        CategoryService $categoryService,
        PostService $postService
    ) {
        parent::__construct($view, $response);
        $this->categoryService = $categoryService;
        $this->postService = $postService;
    }

    public function show(int $id, Request $request): void
    {
        $category = $this->categoryService->getCategory($id);

        if ($category === null) {
            throw new NotFoundException('Category not found');
        }

        $sortParam = (string) $request->query('sort', 'date');
        $directionParam = strtoupper((string) $request->query('direction', 'DESC'));
        $page = (int) $request->query('page', 1);
        $perPage = 5;

        $sortBy = $sortParam === 'views' ? 'views_count' : 'created_at';
        $direction = $directionParam === 'ASC' ? 'ASC' : 'DESC';

        $posts = $this->postService->getPostsByCategoryId($id, $page, $perPage, $sortBy, $direction);
        $totalPosts = $this->postService->countByCategoryId($id);
        $totalPages = max(1, (int) ceil($totalPosts / $perPage));
        $currentPage = max(1, min($page, $totalPages));

        $this->render('category.tpl', [
            'title' => 'Категория',
            'category' => $category,
            'posts' => $posts,
            'pagination' => [
                'current' => $currentPage,
                'total' => $totalPages,
                'has_prev' => $currentPage > 1,
                'has_next' => $currentPage < $totalPages,
                'prev_page' => $currentPage - 1,
                'next_page' => $currentPage + 1,
            ],
            'filters' => [
                'sort' => $sortParam,
                'direction' => $direction,
            ],
        ]);
    }
}
