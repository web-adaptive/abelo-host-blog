<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\CategoryDTO;
use App\Repositories\CategoryRepository;

final class CategoryService
{
    public function __construct(private readonly CategoryRepository $categoryRepository)
    {
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
}
