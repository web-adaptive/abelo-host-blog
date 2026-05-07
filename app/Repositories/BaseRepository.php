<?php

declare(strict_types=1);

namespace App\Repositories;

use PDO;

/**
 * Базовый репозиторий с общими методами чтения из БД.
 */
abstract class BaseRepository
{
    public function __construct(protected readonly PDO $connection)
    {
    }

    /**
     * Выполняет запрос и возвращает все найденные строки.
     *
     * @param string $sql SQL-запрос.
     * @param array<string, mixed> $params Параметры prepared statement.
     * @return list<array<string, mixed>>
     */
    protected function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll() ?: [];
    }

    /**
     * Выполняет запрос и возвращает одну строку или null.
     *
     * @param string $sql SQL-запрос.
     * @param array<string, mixed> $params Параметры prepared statement.
     * @return array<string, mixed>|null
     */
    protected function fetchOne(string $sql, array $params = []): ?array
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch();

        return $row === false ? null : $row;
    }
}
