<?php

declare(strict_types=1);

namespace App\Repositories;

final class PostRepository extends BaseRepository
{
    public function getPost(int $id): ?array
    {
        return $this->fetchOne(
            'SELECT id, title, description, text, status, img, views_count, sort FROM posts WHERE id = :id LIMIT 1',
            ['id' => $id]
        );
    }

    public function getPaginated(
        int $page = 1,
        int $perPage = 10,
        string $sortBy = 'created_at',
        string $direction = 'DESC'
    ): array
    {
        $allowedSortBy = ['created_at', 'views_count', 'sort', 'title'];
        $sortColumn = in_array($sortBy, $allowedSortBy, true) ? $sortBy : 'created_at';
        $sortDirection = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';

        $page = max(1, $page);
        $perPage = max(1, min($perPage, 100));
        $offset = ($page - 1) * $perPage;

        $sql = sprintf(
            'SELECT id, title, description, text, status, img, views_count, sort, created_at
             FROM posts
             ORDER BY %s %s
             LIMIT %d OFFSET %d',
            $sortColumn,
            $sortDirection,
            $perPage,
            $offset
        );

        return $this->fetchAll($sql);
    }

    public function getPostsByCategoryId(
        int $categoryId,
        int $page = 1,
        int $perPage = 10,
        string $sortBy = 'created_at',
        string $direction = 'DESC'
    ): array
    {
        $allowedSortBy = ['created_at', 'views_count', 'sort', 'title'];
        $sortColumn = in_array($sortBy, $allowedSortBy, true) ? $sortBy : 'created_at';
        $sortDirection = strtoupper($direction) === 'ASC' ? 'ASC' : 'DESC';

        $page = max(1, $page);
        $perPage = max(1, min($perPage, 100));
        $offset = ($page - 1) * $perPage;

        $sql = sprintf(
            'SELECT p.id, p.title, p.description, p.text, p.status, p.img, p.views_count, p.sort, p.created_at
             FROM posts AS p
             INNER JOIN posts_to_category AS pc ON pc.post_id = p.id
             WHERE pc.category_id = :category_id
             ORDER BY p.%s %s
             LIMIT %d OFFSET %d',
            $sortColumn,
            $sortDirection,
            $perPage,
            $offset
        );

        return $this->fetchAll($sql, [
            'category_id' => $categoryId,
        ]);
    }
}
