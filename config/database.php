<?php

declare(strict_types=1);

return [
    'driver' => $_ENV['DB_TYPE'] ?? 'mysql',
    'host' => $_ENV['DB_HOST'] ?? 'mysql',
    'port' => (int) ($_ENV['DB_PORT'] ?? 3306),
    'database' => $_ENV['DB_NAME'] ?? 'app',
    'username' => $_ENV['DB_USERNAME'] ?? 'app',
    'password' => $_ENV['DB_PASSWORD'] ?? 'app',
    'charset' => 'utf8mb4',
];
