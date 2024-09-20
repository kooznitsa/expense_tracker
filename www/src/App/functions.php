<?php

declare(strict_types=1);

use JetBrains\PhpStorm\NoReturn;

#[NoReturn] function dd(mixed $value): void
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}
