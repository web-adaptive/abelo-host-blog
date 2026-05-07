<?php

declare(strict_types=1);

namespace App\Repositories;

final class PostRepository extends BaseRepository
{
    public function getPost(int $id): ?array
    {
        return $this->fetchOne(
            'SELECT id, title, description, text, status, img, views_count, sort, created_at, updated_at FROM posts WHERE id = :id LIMIT 1',
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

    public function countByCategoryId(int $categoryId): int
    {
        $row = $this->fetchOne(
            'SELECT COUNT(*) AS total
             FROM posts AS p
             INNER JOIN posts_to_category AS pc ON pc.post_id = p.id
             WHERE pc.category_id = :category_id',
            ['category_id' => $categoryId]
        );

        return (int) ($row['total'] ?? 0);
    }

    public function getRelatedPosts(int $postId, int $limit = 3): array
    {
        $limit = max(1, min($limit, 10));

        $sql = sprintf(
            'SELECT DISTINCT p2.id, p2.title, p2.description, p2.text, p2.status, p2.img, p2.views_count, p2.sort, p2.created_at, p2.updated_at
             FROM posts_to_category AS pc1
             INNER JOIN posts_to_category AS pc2 ON pc2.category_id = pc1.category_id AND pc2.post_id <> :post_id
             INNER JOIN posts AS p2 ON p2.id = pc2.post_id
             WHERE pc1.post_id = :post_id
             AND p2.status = :status
             ORDER BY p2.created_at DESC, p2.id DESC
             LIMIT %d',
            $limit
        );

        return $this->fetchAll($sql, [
            'post_id' => $postId,
            'status' => 'published',
        ]);
    }
}
