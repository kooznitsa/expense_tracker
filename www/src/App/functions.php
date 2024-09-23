<?php

declare(strict_types=1);

use JetBrains\PhpStorm\NoReturn;

/*
 * Prints a variable in user-friendly manner.
 */
#[NoReturn] function dd(mixed $value): void
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

/*
 * Helps escaping data.
 */
function e(mixed $value): string
{
    return htmlspecialchars((string) $value);
}
