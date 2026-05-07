<?php

declare(strict_types=1);

namespace App\Repositories;

final class SeedRepository extends BaseRepository
{
    public function reseed(): array
    {
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

        $posts = [
            [1, 'Что нового в PHP 8.4', 'Краткий обзор новых возможностей PHP 8.4', 'Подробный текст поста про PHP 8.4...', 'published', null, 128, 10],
            [2, 'Индексы в MySQL', 'Как ускорить выборки с помощью индексов', 'Подробный текст поста про индексы...', 'published', null, 95, 20],
            [3, 'Настройка Nginx для PHP-FPM', 'Базовый конфиг и рекомендации', 'Подробный текст поста про Nginx + PHP-FPM...', 'published', null, 76, 30],
            [4, 'Docker Compose для блога', 'Как собрать локальное окружение', 'Подробный текст поста про Docker Compose...', 'published', null, 88, 40],
            [5, 'Service-Repository подход', 'Почему важно разделять слои', 'Подробный текст поста про сервисы и репозитории...', 'published', null, 64, 50],
            [6, 'PDO и безопасные запросы', 'Подготовленные выражения и защита от SQL-инъекций', 'Подробный текст поста про PDO...', 'published', null, 53, 60],
            [7, 'Маршрутизация в PHP проекте', 'Простой Router для MVC', 'Подробный текст поста про роутинг...', 'published', null, 42, 70],
            [8, 'Кэширование в Nginx', 'Базовые подходы к кэшированию', 'Подробный текст поста про cache...', 'published', null, 39, 80],
            [9, 'Связь many-to-many в MySQL', 'Таблица posts_to_category на практике', 'Подробный текст поста про many-to-many...', 'published', null, 31, 90],
            [10, 'Ошибки и Exception Handler', 'Единая обработка ошибок в приложении', 'Подробный текст поста про exception handler...', 'published', null, 27, 100],
        ];

        $relations = [
            [1, 1], [2, 2], [3, 3], [5, 5],
            [6, 1], [6, 2], [7, 5], [8, 3], [9, 2],
            [9, 5], [10, 5], [10, 1],
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
        foreach ($posts as $post) {
            $postStmt->execute([
                'id' => $post[0],
                'title' => $post[1],
                'description' => $post[2],
                'text' => $post[3],
                'status' => $post[4],
                'img' => $post[5],
                'views_count' => $post[6],
                'sort' => $post[7],
            ]);
        }

        $relationStmt = $this->connection->prepare(
            'INSERT INTO posts_to_category (post_id, category_id) VALUES (:post_id, :category_id)'
        );
        foreach ($relations as $relation) {
            $relationStmt->execute([
                'post_id' => $relation[0],
                'category_id' => $relation[1],
            ]);
        }

        $this->connection->commit();

        return [
            'categories' => count($categories),
            'posts' => count($posts),
            'relations' => count($relations),
        ];
    }
}
