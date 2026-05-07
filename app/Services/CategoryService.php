<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\CategoryDTO;
use App\Models\Category;
use App\Models\Post;
use App\Repositories\CategoryRepository;

/**
 * Сервис бизнес-логики категорий.
 */
final class CategoryService
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Возвращает список всех категорий в виде DTO.
     *
     * @return list<CategoryDTO>
     */
    public function getAll(): array
    {
        $items = $this->categoryRepository->getAll();

        return array_map(
            static fn (Category $category): CategoryDTO => new CategoryDTO(
                $category->id,
                $category->title,
                $category->description,
                $category->status
            ),
            $items
        );
    }

    /**
     * Возвращает категорию по id или null.
     *
     * @param int $id Идентификатор категории.
     * @return CategoryDTO|null
     */
    public function getCategory(int $id): ?CategoryDTO
    {
        $category = $this->categoryRepository->getCategory($id);
        if ($category === null) {
            return null;
        }

        return new CategoryDTO(
            $category->id,
            $category->title,
            $category->description,
            $category->status
        );
    }

    /**
     * Возвращает категории для главной страницы с ограниченным числом постов.
     *
     * @param int $postsLimit Лимит постов на категорию.
     * @return list<array{id:int,title:string,description:?string,posts:list<array{id:int,title:string,description:?string,img:?string,created_at:string}>}>
     */
    public function getHomeCategoriesWithPosts(int $postsLimit = 3): array
    {
        $rows = $this->categoryRepository->getCategoriesWithLatestPosts($postsLimit);
        $result = [];

        foreach ($rows as $row) {
            /** @var Category $category */
            $category = $row['category'];
            /** @var Post $post */
            $post = $row['post'];
            $categoryId = $category->id;

            if (!isset($result[$categoryId])) {
                $result[$categoryId] = [
                    'id' => $category->id,
                    'title' => $category->title,
                    'description' => $category->description,
                    'posts' => [],
                ];
            }

            $result[$categoryId]['posts'][] = [
                'id' => $post->id,
                'title' => $post->title,
                'description' => $post->description,
                'img' => $post->img,
                'created_at' => (string) $post->createdAt,
            ];
        }

        return array_values($result);
    }
}
