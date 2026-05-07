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

WITH RECURSIVE seq AS (
    SELECT 1 AS n
    UNION ALL
    SELECT n + 1 FROM seq WHERE n < 500
)
INSERT INTO posts (id, title, description, text, status, img, views_count, sort)
SELECT
    n,
    CONCAT('Пост #', n),
    CONCAT('Краткое описание поста #', n),
    CONCAT('Полный текст поста #', n, '. Lorem ipsum dolor sit amet.'),
    'published',
    IF(MOD(n, 2) = 0, '/assets/images/posts/cat-2.png', '/assets/images/posts/cat-1.png'),
    20 + MOD(n * 13, 5000),
    n
FROM seq;

WITH RECURSIVE seq AS (
    SELECT 1 AS n
    UNION ALL
    SELECT n + 1 FROM seq WHERE n < 500
)
INSERT INTO posts_to_category (post_id, category_id)
SELECT
    n,
    CASE MOD(n, 4)
        WHEN 1 THEN 1
        WHEN 2 THEN 2
        WHEN 3 THEN 3
        ELSE 5
    END
FROM seq;

COMMIT;
