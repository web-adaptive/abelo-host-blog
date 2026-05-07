<?php

declare(strict_types=1);

/**
 * Достаёт значение из конфигов по ключу формата "section.key".
 *
 * @param string $key Ключ вида "section.option".
 * @param mixed $default Значение по умолчанию.
 * @return mixed
 */
function config(string $key, mixed $default = null): mixed
{
    static $items = null;

    if ($items === null) {
        $root = dirname(__DIR__, 2) . '/config';
        $items = [
            'app' => require $root . '/app.php',
            'database' => require $root . '/database.php',
        ];
    }

    $segments = explode('.', $key);
    $value = $items;

    foreach ($segments as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $default;
        }
        $value = $value[$segment];
    }

    return $value;
}
