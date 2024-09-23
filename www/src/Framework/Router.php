<?php

declare(strict_types=1);

namespace Framework;

class Router
{
    private array $routes = [];

    /*
     * Adds a path to the array of paths.
     */
    public function add(string $method, string $path, array $controller): void
    {
        $path  = $this->normalizePath($path);

        $this->routes[] = [
            "path" => $path,
            "method" => strtoupper($method),
            "controller" => $controller,
        ];
    }

    /*
     * Replaces slashes if they exist, wraps a path into slashes.
     */
    private function normalizePath(string $path): string
    {
        $path = "/" . trim($path, "/") . "/";
        return preg_replace("#[/]{2,}#", "/", $path);
    }

    public function dispatch(string $path, string $method): void
    {
        $path = $this->normalizePath($path);
        $method = strtoupper($method);

        foreach ($this->routes as $route) {
            if (!preg_match("#^{$route['path']}$#", $path) || $route['method'] !== $method) {
                continue;
            }

            [$class, $function] = $route["controller"];

            $controllerInstance = new $class;
            $controllerInstance->$function();
        }
    }
}
