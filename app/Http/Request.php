<?php

declare(strict_types=1);

namespace App\Http;

/**
 * Объект HTTP-запроса.
 */
final class Request
{
    public function __construct(
        private readonly string $method,
        private readonly string $path,
        private readonly array $queryParams = []
    ) {
    }

    /**
     * Создаёт объект запроса на основе superglobal.
     *
     * @return self
     */
    public static function capture(): self
    {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

        return new self($method, $path, $_GET);
    }

    /**
     * Возвращает HTTP-метод запроса.
     *
     * @return string
     */
    public function method(): string
    {
        return $this->method;
    }

    /**
     * Возвращает путь запроса без query-string.
     *
     * @return string
     */
    public function path(): string
    {
        return $this->path;
    }

    /**
     * Возвращает query-параметр по ключу.
     *
     * @param string $key Имя query-параметра.
     * @param mixed $default Значение по умолчанию.
     * @return mixed
     */
    public function query(string $key, mixed $default = null): mixed
    {
        return $this->queryParams[$key] ?? $default;
    }
}
