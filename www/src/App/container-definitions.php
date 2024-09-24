<?php

declare(strict_types=1);

use Framework\{Database, TemplateEngine};
use App\Config\Paths;
use App\Services\ValidatorService;

return [
    TemplateEngine::class => fn() => new TemplateEngine(Paths::VIEW),
    ValidatorService::class => fn() => new ValidatorService(),
    Database::class => fn() => new Database(
        $_ENV["MYSQL_DRIVER"],
        [
            "host" => $_ENV["MYSQL_HOST"],
            "port" => $_ENV["HOST_MACHINE_MYSQL_PORT"],
            "dbname" => $_ENV["MYSQL_DATABASE"],
        ],
        $_ENV["MYSQL_USER"],
        $_ENV["MYSQL_PASSWORD"]),
];
