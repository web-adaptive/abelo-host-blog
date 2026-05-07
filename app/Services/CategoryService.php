<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\CategoryDTO;
use App\Repositories\CategoryRepository;

final class CategoryService
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll(): array
    {
        $items = $this->categoryRepository->getAll();

        return array_map(
            static fn (array $row): CategoryDTO => new CategoryDTO(
                (int) $row['id'],
                (string) $row['title'],
                $row['description'] !== null ? (string) $row['description'] : null,
                (string) $row['status']
            ),
            $items
        );
    }

    public function getCategory(int $id): ?CategoryDTO
    {
        $row = $this->categoryRepository->getCategory($id);

        if ($row === null) {
            return null;
        }

        return new CategoryDTO(
            (int) $row['id'],
            (string) $row['title'],
            $row['description'] !== null ? (string) $row['description'] : null,
            (string) $row['status']
        );
    }

    public function getHomeCategoriesWithPosts(int $postsLimit = 3): array
    {
        $rows = $this->categoryRepository->getCategoriesWithLatestPosts($postsLimit);
        $result = [];

        foreach ($rows as $row) {
            $categoryId = (int) $row['category_id'];

            if (!isset($result[$categoryId])) {
                $result[$categoryId] = [
                    'id' => $categoryId,
                    'title' => (string) $row['category_title'],
                    'description' => $row['category_description'] !== null ? (string) $row['category_description'] : null,
                    'posts' => [],
                ];
            }

            $result[$categoryId]['posts'][] = [
                'id' => (int) $row['post_id'],
                'title' => (string) $row['post_title'],
                'description' => $row['post_description'] !== null ? (string) $row['post_description'] : null,
                'created_at' => (string) $row['post_created_at'],
            ];
        }

        return array_values($result);
    }
}
