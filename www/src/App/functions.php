<?php

declare(strict_types=1);

use Framework\Enums\Http;

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
    http_response_code(Http::REDIRECT_STATUS_CODE->value);
    exit;
}
