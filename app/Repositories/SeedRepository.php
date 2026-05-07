<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\StatusPostEnum;

/**
 * Репозиторий сидирования тестовых данных.
 */
final class SeedRepository extends BaseRepository
{
    private const POSTS_TOTAL = 500;

    /**
     * Полностью очищает и повторно заполняет таблицы.
     *
     * @return array{categories:int,posts:int,relations:int}
     * @throws \Throwable Если транзакция или вставка завершились ошибкой.
     */
    public function reseed(): array
    {
        try {
            $this->connection->exec('SET NAMES utf8mb4');
            $this->connection->beginTransaction();

            $this->connection->exec('DELETE FROM posts_to_category');
            $this->connection->exec('DELETE FROM posts');
            $this->connection->exec('DELETE FROM category');

            $categories = [
                [1, 'PHP', 'Новости и заметки о PHP', 'published'],
                [2, 'MySQL', 'Работа с базами данных', 'published'],
                [3, 'Nginx', 'Конфигурация и оптимизация Nginx', 'published'],
                [4, 'Docker', 'Контейнеризация и окружение', 'published'],
                [5, 'Архитектура', 'Паттерны и структура проекта', 'published'],
            ];

            $categoryStmt = $this->connection->prepare(
                'INSERT INTO category (id, title, description, status) VALUES (:id, :title, :description, :status)'
            );
            foreach ($categories as $category) {
                $categoryStmt->execute([
                    'id' => $category[0],
                    'title' => $category[1],
                    'description' => $category[2],
                    'status' => $category[3],
                ]);
            }

            $postStmt = $this->connection->prepare(
                'INSERT INTO posts (id, title, description, text, status, img, views_count, sort)
                 VALUES (:id, :title, :description, :text, :status, :img, :views_count, :sort)'
            );
            for ($postId = 1; $postId <= self::POSTS_TOTAL; $postId++) {
                $postStmt->execute([
                    'id' => $postId,
                    'title' => 'Пост #' . $postId,
                    'description' => 'Краткое описание поста #' . $postId,
                    'text' => 'Полный текст поста #' . $postId . '. Lorem ipsum dolor sit amet.',
                    'status' => StatusPostEnum::Published->value,
                    'img' => $postId % 2 === 0 ? '/assets/images/posts/cat-2.png' : '/assets/images/posts/cat-1.png',
                    'views_count' => 20 + (($postId * 13) % 5000),
                    'sort' => $postId,
                ]);
            }

            $relationStmt = $this->connection->prepare(
                'INSERT INTO posts_to_category (post_id, category_id) VALUES (:post_id, :category_id)'
            );
            $relationsCount = 0;
            for ($postId = 1; $postId <= self::POSTS_TOTAL; $postId++) {
                $categoryId = match ($postId % 4) {
                    1 => 1,
                    2 => 2,
                    3 => 3,
                    default => 5,
                };
                $relationStmt->execute([
                    'post_id' => $postId,
                    'category_id' => $categoryId,
                ]);
                $relationsCount++;
            }

            $this->connection->commit();

            return [
                'categories' => count($categories),
                'posts' => self::POSTS_TOTAL,
                'relations' => $relationsCount,
            ];
        } catch (\Throwable $exception) {
            if ($this->connection->inTransaction()) {
                $this->connection->rollBack();
            }
            throw $exception;
        }
    }
}
