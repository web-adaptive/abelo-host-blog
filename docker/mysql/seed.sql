USE app;
SET NAMES utf8mb4;

START TRANSACTION;

DELETE FROM posts_to_category;
DELETE FROM posts;
DELETE FROM category;

INSERT INTO category (id, title, description, status) VALUES
    (1, 'PHP', 'Новости и заметки о PHP', 'published'),
    (2, 'MySQL', 'Работа с базами данных', 'published'),
    (3, 'Nginx', 'Конфигурация и оптимизация Nginx', 'published'),
    (4, 'Docker', 'Контейнеризация и окружение', 'published'),
    (5, 'Архитектура', 'Паттерны и структура проекта', 'published');

INSERT INTO posts (id, title, description, text, status, img, views_count, sort) VALUES
    (1, 'Что нового в PHP 8.4', 'Краткий обзор новых возможностей PHP 8.4', 'Подробный текст поста про PHP 8.4...', 'published', '/assets/images/posts/cat-1.png', 128, 10),
    (2, 'Индексы в MySQL', 'Как ускорить выборки с помощью индексов', 'Подробный текст поста про индексы...', 'published', '/assets/images/posts/cat-2.png', 95, 20),
    (3, 'Настройка Nginx для PHP-FPM', 'Базовый конфиг и рекомендации', 'Подробный текст поста про Nginx + PHP-FPM...', 'published', '/assets/images/posts/cat-1.png', 76, 30),
    (4, 'Docker Compose для блога', 'Как собрать локальное окружение', 'Подробный текст поста про Docker Compose...', 'published', '/assets/images/posts/cat-2.png', 88, 40),
    (5, 'Service-Repository подход', 'Почему важно разделять слои', 'Подробный текст поста про сервисы и репозитории...', 'published', '/assets/images/posts/cat-1.png', 64, 50),
    (6, 'PDO и безопасные запросы', 'Подготовленные выражения и защита от SQL-инъекций', 'Подробный текст поста про PDO...', 'published', '/assets/images/posts/cat-2.png', 53, 60),
    (7, 'Маршрутизация в PHP проекте', 'Простой Router для MVC', 'Подробный текст поста про роутинг...', 'published', '/assets/images/posts/cat-1.png', 42, 70),
    (8, 'Кэширование в Nginx', 'Базовые подходы к кэшированию', 'Подробный текст поста про cache...', 'published', '/assets/images/posts/cat-2.png', 39, 80),
    (9, 'Связь many-to-many в MySQL', 'Таблица posts_to_category на практике', 'Подробный текст поста про many-to-many...', 'published', '/assets/images/posts/cat-1.png', 31, 90),
    (10, 'Ошибки и Exception Handler', 'Единая обработка ошибок в приложении', 'Подробный текст поста про exception handler...', 'published', '/assets/images/posts/cat-2.png', 27, 100);

INSERT INTO posts_to_category (post_id, category_id) VALUES
    (1, 1),
    (2, 2),
    (3, 3),
    (5, 5),
    (6, 1),
    (6, 2),
    (7, 5),
    (8, 3),
    (9, 2),
    (9, 5),
    (10, 5),
    (10, 1);

COMMIT;
