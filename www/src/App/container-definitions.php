<?php

declare(strict_types=1);

use Framework\{Container, Database, TemplateEngine};
use App\Config\Paths;
use App\Services\{UserService, ReceiptService, TransactionService, ValidatorService};

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
        $_ENV["MYSQL_PASSWORD"],
    ),
    UserService::class => function (Container $container) {
        $db = $container->get(Database::class);
        return new UserService($db);
    },
    TransactionService::class => function (Container $container) {
        $db = $container->get(Database::class);
        return new TransactionService($db);
    },
    ReceiptService::class => function (Container $container) {
        $db = $container->get(Database::class);
        return new ReceiptService($db);
    },
];
