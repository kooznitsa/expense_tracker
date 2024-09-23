<?php

declare(strict_types=1);

namespace Framework;

class TemplateEngine
{
    public function __construct(
        private string $basePath,
    ) {}

    /* Renders HTML. */
    public function render(string $template, array $data = []): string|false
    {
        extract($data, EXTR_SKIP);
        ob_start();
        include $this->resolve($template);
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    /* Creates an absolute path. */
    public function resolve(string $path): string
    {
        return "$this->basePath/$path";
    }
}
