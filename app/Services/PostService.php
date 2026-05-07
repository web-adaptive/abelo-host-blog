<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\PostDTO;
use App\Repositories\PostRepository;

final class PostService
{
    public function __construct(private readonly PostRepository $postRepository)
    {
    }

    public function getPost(int $id): ?PostDTO
    {
        $row = $this->postRepository->getPost($id);

        if ($row === null) {
            return null;
        }

        return new PostDTO(
            (int) $row['id'],
            (string) $row['title'],
            $row['description'] !== null ? (string) $row['description'] : null,
            (string) $row['text'],
            (string) $row['status'],
            $row['img'] !== null ? (string) $row['img'] : null,
            (int) $row['views_count'],
            (int) $row['sort']
        );
    }

    public function getPaginated(
        int $page = 1,
        int $perPage = 10,
        string $sortBy = 'created_at',
        string $direction = 'DESC'
    ): array {
        $rows = $this->postRepository->getPaginated($page, $perPage, $sortBy, $direction);

        return array_map(fn (array $row): PostDTO => $this->mapDto($row), $rows);
    }

    public function getPostsByCategoryId(
        int $categoryId,
        int $page = 1,
        int $perPage = 10,
        string $sortBy = 'created_at',
        string $direction = 'DESC'
    ): array {
        $rows = $this->postRepository->getPostsByCategoryId($categoryId, $page, $perPage, $sortBy, $direction);

        return array_map(fn (array $row): PostDTO => $this->mapDto($row), $rows);
    }

    private function mapDto(array $row): PostDTO
    {
        return new PostDTO(
            (int) $row['id'],
            (string) $row['title'],
            $row['description'] !== null ? (string) $row['description'] : null,
            (string) $row['text'],
            (string) $row['status'],
            $row['img'] !== null ? (string) $row['img'] : null,
            (int) $row['views_count'],
            (int) $row['sort']
        );
    }
}
