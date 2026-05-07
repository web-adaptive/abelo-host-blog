<?php

declare(strict_types=1);

namespace App\Routing;

use App\Exceptions\MethodNotAllowedException;
use App\Exceptions\NotFoundException;
use App\Http\Request;

final class Router
{
    private array $routes = [];

    public function get(string $path, callable $handler): void
    {
        $this->add('GET', $path, $handler);
    }

    public function add(string $method, string $path, callable $handler): void
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $path,
            'handler' => $handler,
        ];
    }

    public function dispatch(Request $request): void
    {
        $pathMatched = false;

        foreach ($this->routes as $route) {
            $params = $this->matchPath($route['path'], $request->path());

            if ($params === null) {
                continue;
            }

            $pathMatched = true;

            if ($route['method'] !== $request->method()) {
                continue;
            }

            $args = $params;
            $args[] = $request;
            ($route['handler'])(...$args);
            return;
        }

        if ($pathMatched === true) {
            throw new MethodNotAllowedException();
        }

        throw new NotFoundException();
    }

    private function matchPath(string $routePath, string $requestPath): ?array
    {
        $pattern = preg_replace('#\{[a-zA-Z_][a-zA-Z0-9_]*\}#', '([0-9]+)', $routePath);
        $pattern = '#^' . $pattern . '$#';

        if (preg_match($pattern, $requestPath, $matches) !== 1) {
            return null;
        }

        array_shift($matches);
        return array_map(static fn (string $value): int => (int) $value, $matches);
    }
}
