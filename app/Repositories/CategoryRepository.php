<?php

declare(strict_types=1);

namespace App\Repositories;

final class CategoryRepository extends BaseRepository
{
    public function getAll(): array
    {
        return $this->fetchAll(
            'SELECT id, title, description, status FROM category ORDER BY id DESC'
        );
    }

    public function getCategory(int $id): ?array
    {
        return $this->fetchOne(
            'SELECT id, title, description, status FROM category WHERE id = :id LIMIT 1',
            ['id' => $id]
        );
    }

    public function getCategoriesWithLatestPosts(int $postsLimit = 3): array
    {
        $postsLimit = max(1, $postsLimit);
        $sql = sprintf(
            "SELECT
                c.id AS category_id,
                c.title AS category_title,
                c.description AS category_description,
                c.status AS category_status,
                p.id AS post_id,
                p.title AS post_title,
                p.description AS post_description,
                p.created_at AS post_created_at
            FROM category AS c
            INNER JOIN (
                SELECT
                    pc.category_id,
                    p.id,
                    p.title,
                    p.description,
                    p.created_at,
                    ROW_NUMBER() OVER (
                        PARTITION BY pc.category_id
                        ORDER BY p.created_at DESC, p.id DESC
                    ) AS row_num
                FROM posts AS p
                INNER JOIN posts_to_category AS pc ON pc.post_id = p.id
                WHERE p.status = 'published'
            ) AS p ON p.category_id = c.id AND p.row_num <= %d
            WHERE c.status = 'published'
            ORDER BY c.id DESC, p.created_at DESC, p.id DESC",
            $postsLimit
        );

        return $this->fetchAll($sql);
    }
}
