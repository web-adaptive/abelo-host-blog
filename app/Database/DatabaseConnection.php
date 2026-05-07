<?php

declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOException;
use RuntimeException;

final class DatabaseConnection
{
    private static ?self $instance = null;
    private PDO $connection;

    private function __construct()
    {
        $driver = (string) config('database.driver', 'mysql');
        $host = (string) config('database.host', 'mysql');
        $port = (string) config('database.port', 3306);
        $dbName = (string) config('database.database', 'app');
        $user = (string) config('database.username', 'app');
        $password = (string) config('database.password', 'app');

        $dsn = sprintf('%s:host=%s;port=%s;dbname=%s;charset=utf8mb4', $driver, $host, $port, $dbName);

        try {
            $this->connection = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $exception) {
            throw new RuntimeException('Database connection failed: ' . $exception->getMessage(), 0, $exception);
        }
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
