<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\StatusPostEnum;
use App\Models\Post;

/**
 * Репозиторий чтения данных постов.
 */
final class PostRepository extends BaseRepository
{
    private const DEFAULT_SORT_BY = 'created_at';
    private const DEFAULT_DIRECTION = 'DESC';
    private const MIN_PAGE = 1;
    private const MIN_PER_PAGE = 1;
    private const MAX_PER_PAGE = 100;
    private const DEFAULT_RELATED_LIMIT = 3;
    private const MAX_RELATED_LIMIT = 10;

    /**
     * Возвращает пост по id.
     *
     * @param int $id Идентификатор поста.
     * @return Post|null Модель поста или null.
     */
    public function getPost(int $id): ?Post
    {
        $row = $this->fetchOne(
            'SELECT id, title, description, text, status, img, views_count, sort, created_at, updated_at
             FROM posts
             WHERE id = :id AND status = :status
             LIMIT 1',
            [
                'id' => $id,
                'status' => StatusPostEnum::Published->value,
            ]
        );

        return $row === null ? null : $this->mapPost($row);
    }

    /**
     * Возвращает все посты с пагинацией и сортировкой.
     *
     * @param int $page Номер страницы.
     * @param int $perPage Количество записей на страницу.
     * @param string $sortBy Поле сортировки.
     * @param string $direction Направление сортировки.
     * @return list<Post> Список моделей постов.
     */
    public function getPaginated(
        int $page = 1,
        int $perPage = 10,
        string $sortBy = self::DEFAULT_SORT_BY,
        string $direction = self::DEFAULT_DIRECTION
    ): array
    {
        $allowedSortBy = ['created_at', 'views_count', 'sort', 'title'];
        $sortColumn = in_array($sortBy, $allowedSortBy, true) ? $sortBy : self::DEFAULT_SORT_BY;
        $sortDirection = strtoupper($direction) === 'ASC' ? 'ASC' : self::DEFAULT_DIRECTION;

        $page = max(self::MIN_PAGE, $page);
        $perPage = max(self::MIN_PER_PAGE, min($perPage, self::MAX_PER_PAGE));
        $offset = ($page - 1) * $perPage;

        $sql = sprintf(
            'SELECT id, title, description, text, status, img, views_count, sort, created_at
             FROM posts
             WHERE status = :status
             ORDER BY %s %s
             LIMIT %d OFFSET %d',
            $sortColumn,
            $sortDirection,
            $perPage,
            $offset
        );

        $rows = $this->fetchAll($sql, [
            'status' => StatusPostEnum::Published->value,
        ]);
        return array_map(fn (array $row): Post => $this->mapPost($row), $rows);
    }

    /**
     * Возвращает посты конкретной категории с пагинацией и сортировкой.
     *
     * @param int $categoryId Идентификатор категории.
     * @param int $page Номер страницы.
     * @param int $perPage Количество записей на страницу.
     * @param string $sortBy Поле сортировки.
     * @param string $direction Направление сортировки.
     * @return list<Post> Список моделей постов.
     */
    public function getPostsByCategoryId(
        int $categoryId,
        int $page = 1,
        int $perPage = 10,
        string $sortBy = self::DEFAULT_SORT_BY,
        string $direction = self::DEFAULT_DIRECTION
    ): array
    {
        $allowedSortBy = ['created_at', 'views_count', 'sort', 'title'];
        $sortColumn = in_array($sortBy, $allowedSortBy, true) ? $sortBy : self::DEFAULT_SORT_BY;
        $sortDirection = strtoupper($direction) === 'ASC' ? 'ASC' : self::DEFAULT_DIRECTION;

        $page = max(self::MIN_PAGE, $page);
        $perPage = max(self::MIN_PER_PAGE, min($perPage, self::MAX_PER_PAGE));
        $offset = ($page - 1) * $perPage;

        $sql = sprintf(
            'SELECT p.id, p.title, p.description, p.text, p.status, p.img, p.views_count, p.sort, p.created_at
             FROM posts AS p
             INNER JOIN posts_to_category AS pc ON pc.post_id = p.id
             WHERE pc.category_id = :category_id
             AND p.status = :status
             ORDER BY p.%s %s
             LIMIT %d OFFSET %d',
            $sortColumn,
            $sortDirection,
            $perPage,
            $offset
        );

        $rows = $this->fetchAll($sql, [
            'category_id' => $categoryId,
            'status' => StatusPostEnum::Published->value,
        ]);

        return array_map(fn (array $row): Post => $this->mapPost($row), $rows);
    }

    /**
     * Возвращает количество постов в категории.
     *
     * @param int $categoryId Идентификатор категории.
     * @return int
     */
    public function countByCategoryId(int $categoryId): int
    {
        $row = $this->fetchOne(
            'SELECT COUNT(*) AS total
             FROM posts AS p
             INNER JOIN posts_to_category AS pc ON pc.post_id = p.id
             WHERE pc.category_id = :category_id
             AND p.status = :status',
            [
                'category_id' => $categoryId,
                'status' => StatusPostEnum::Published->value,
            ]
        );

        return (int) ($row['total'] ?? 0);
    }

    /**
     * Возвращает похожие посты (по общим категориям).
     *
     * @param int $postId Идентификатор текущего поста.
     * @param int $limit Максимальное количество похожих постов.
     * @return list<Post> Список моделей похожих постов.
     */
    public function getRelatedPosts(int $postId, int $limit = self::DEFAULT_RELATED_LIMIT): array
    {
        $limit = max(self::MIN_PER_PAGE, min($limit, self::MAX_RELATED_LIMIT));

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

        $rows = $this->fetchAll($sql, [
            'post_id' => $postId,
            'status' => StatusPostEnum::Published->value,
        ]);

        return array_map(fn (array $row): Post => $this->mapPost($row), $rows);
    }

    /**
     * Преобразует строку БД в модель поста.
     *
     * @param array<string, mixed> $row Строка результата SQL-запроса.
     * @return Post
     */
    private function mapPost(array $row): Post
    {
        return new Post(
            (int) $row['id'],
            (string) $row['title'],
            $row['description'] !== null ? (string) $row['description'] : null,
            (string) ($row['text'] ?? ''),
            (string) ($row['status'] ?? StatusPostEnum::Published->value),
            $row['img'] !== null ? (string) $row['img'] : null,
            (int) ($row['views_count'] ?? 0),
            (int) ($row['sort'] ?? 0),
            isset($row['created_at']) ? (string) $row['created_at'] : null,
            isset($row['updated_at']) ? (string) $row['updated_at'] : null
        );
    }
}
