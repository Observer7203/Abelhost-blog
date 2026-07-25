<?php

namespace App;

class Router
{
    private array $routes = [];

    public function add(string $method, string $path, callable|array $handler): void
    {
        $this->routes[] = compact('method', 'path', 'handler');
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH);
        $path = '/' . trim($path, '/');

        foreach ($this->routes as $route) {
            $pattern = preg_replace('#\{[a-z]+\}#', '(\d+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if ($route['method'] === $method && preg_match($pattern, $path, $m)) {
                array_shift($m);    
                [$class, $action] = $route['handler'];
                (new $class())->$action(...$m);
                return;
            }
        }

        http_response_code(404);
        echo '404 Not Found';
    }
}