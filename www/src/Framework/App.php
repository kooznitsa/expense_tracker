<?php

declare(strict_types=1);

namespace Framework;

class App
{
    public function __construct(
        public ?string $containerDefinitionsPath = null,
        private Router $router = new Router(),
        private Container $container = new Container(),
    ) {
        if ($containerDefinitionsPath) {
            $containerDefinitions = include $containerDefinitionsPath;
            $this->container->addDefinitions($containerDefinitions);
        }
    }

    public function run(): void
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];

        $this->router->dispatch($path, $method, $this->container);
    }

    public function get(string $path, array $controller): App
    {
        $this->router->add("GET", $path, $controller);

        return $this;
    }

    public function post(string $path, array $controller): App
    {
        $this->router->add("POST", $path, $controller);

        return $this;
    }

    public function addMiddleware(string $middleware): void
    {
        $this->router->addMiddleware($middleware);
    }

    public function add(string $middleware): void
    {
        $this->router->addRouteMiddleware($middleware);
    }
}
