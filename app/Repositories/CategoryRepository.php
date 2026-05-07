<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Category;
use App\Models\Post;

/**
 * Репозиторий чтения данных категорий.
 */
final class CategoryRepository extends BaseRepository
{
    /**
     * Возвращает все категории.
     *
     * @return list<Category> Список моделей категорий.
     */
    public function getAll(): array
    {
        $rows = $this->fetchAll(
            'SELECT id, title, description, status FROM category ORDER BY id DESC'
        );

        return array_map(fn (array $row): Category => $this->mapCategory($row), $rows);
    }

    /**
     * Возвращает категорию по id.
     *
     * @param int $id Идентификатор категории.
     * @return Category|null Модель категории или null.
     */
    public function getCategory(int $id): ?Category
    {
        $row = $this->fetchOne(
            'SELECT id, title, description, status FROM category WHERE id = :id LIMIT 1',
            ['id' => $id]
        );

        return $row === null ? null : $this->mapCategory($row);
    }

    /**
     * Возвращает категории с ограниченным числом последних постов.
     *
     * @param int $postsLimit Лимит постов на категорию.
     * @return list<array{category:Category,post:Post}>
     */
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
                p.text AS post_text,
                p.status AS post_status,
                p.img AS post_img,
                p.views_count AS post_views_count,
                p.sort AS post_sort,
                p.created_at AS post_created_at
            FROM category AS c
            INNER JOIN (
                SELECT
                    pc.category_id,
                    p.id,
                    p.title,
                    p.description,
                    p.text,
                    p.status,
                    p.img,
                    p.views_count,
                    p.sort,
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

        $rows = $this->fetchAll($sql);

        return array_map(function (array $row): array {
            return [
                'category' => new Category(
                    (int) $row['category_id'],
                    (string) $row['category_title'],
                    $row['category_description'] !== null ? (string) $row['category_description'] : null,
                    (string) $row['category_status']
                ),
                'post' => new Post(
                    (int) $row['post_id'],
                    (string) $row['post_title'],
                    $row['post_description'] !== null ? (string) $row['post_description'] : null,
                    (string) $row['post_text'],
                    (string) $row['post_status'],
                    $row['post_img'] !== null ? (string) $row['post_img'] : null,
                    (int) $row['post_views_count'],
                    (int) $row['post_sort'],
                    $row['post_created_at'] !== null ? (string) $row['post_created_at'] : null,
                    null
                ),
            ];
        }, $rows);
    }

    /**
     * Преобразует строку БД в модель категории.
     *
     * @param array<string, mixed> $row Строка результата SQL-запроса.
     * @return Category
     */
    private function mapCategory(array $row): Category
    {
        return new Category(
            (int) $row['id'],
            (string) $row['title'],
            $row['description'] !== null ? (string) $row['description'] : null,
            (string) $row['status']
        );
    }
}
