<?php

declare(strict_types=1);

/*
 * Prints a variable in user-friendly manner.
 */
function dd(mixed $value): void
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

/*
 * Redirects to specified URL.
 */
function redirectTo(string $path): void
{
    header("Location: $path");
    http_response_code(302);
    exit;
}
