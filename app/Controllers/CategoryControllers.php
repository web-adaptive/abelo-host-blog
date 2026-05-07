<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Request;
use App\Http\Response;
use App\Services\CategoryService;
use App\Services\PostService;
use App\View\ViewRenderer;

/**
 * Контроллер страницы категории.
 */
final class CategoryControllers extends BaseController
{
    private const DEFAULT_PAGE = 1;
    private const PER_PAGE = 5;
    private const PAGINATION_WINDOW = 1;

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

    /**
     * Показывает категорию со списком постов, сортировкой и пагинацией.
     *
     * @param int $id Идентификатор категории.
     * @param Request $request HTTP-запрос.
     * @return void
     * @throws NotFoundException Если категория не найдена.
     */
    public function show(int $id, Request $request): void
    {
        $category = $this->categoryService->getCategory($id);

        if ($category === null) {
            throw new NotFoundException('Category not found');
        }

        $sortParam = (string) $request->query('sort', 'date');
        $directionParam = strtoupper((string) $request->query('direction', 'DESC'));
        $page = (int) $request->query('page', self::DEFAULT_PAGE);
        $perPage = self::PER_PAGE;

        $sortBy = $sortParam === 'views' ? 'views_count' : 'created_at';
        $direction = $directionParam === 'ASC' ? 'ASC' : 'DESC';

        $posts = $this->postService->getPostsByCategoryId($id, $page, $perPage, $sortBy, $direction);
        $totalPosts = $this->postService->countByCategoryId($id);
        $totalPages = max(self::DEFAULT_PAGE, (int) ceil($totalPosts / $perPage));
        $currentPage = max(self::DEFAULT_PAGE, min($page, $totalPages));

        $pages = [self::DEFAULT_PAGE];
        $windowStart = max(self::DEFAULT_PAGE + 1, $currentPage - self::PAGINATION_WINDOW);
        $windowEnd = min($totalPages - 1, $currentPage + self::PAGINATION_WINDOW);

        if ($windowStart > self::DEFAULT_PAGE + 1) {
            $pages[] = '...';
        }

        for ($index = $windowStart; $index <= $windowEnd; $index++) {
            $pages[] = $index;
        }

        if ($windowEnd < $totalPages - 1) {
            $pages[] = '...';
        }

        if ($totalPages > self::DEFAULT_PAGE) {
            $pages[] = $totalPages;
        }

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
                'pages' => $pages,
            ],
            'filters' => [
                'sort' => $sortParam,
                'direction' => $direction,
            ],
        ]);
    }
}
