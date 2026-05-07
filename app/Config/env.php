<?php

declare(strict_types=1);

use Dotenv\Dotenv;

// Загружает переменные окружения из .env в $_ENV.
$rootPath = dirname(__DIR__, 2);

if (file_exists($rootPath . '/.env')) {
    $dotenv = Dotenv::createImmutable($rootPath);
    $dotenv->safeLoad();
}
