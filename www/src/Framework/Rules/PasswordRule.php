<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class PasswordRule implements RuleInterface
{
    public function validate(array $formData, string $field, array $params): bool
    {
        $password = $formData[$field];

        if (
            mb_strlen($password) >= 8 &&
            preg_match("/[A-Z]/", $password) &&
            preg_match("/[a-z]/", $password) &&
            preg_match("/[0-9]/", $password)
        ) {
            return true;
        }

        return false;
    }

    public function getMessage(array $formData, string $field, array $params): string
    {
        return
            "Password not strong enough. It should contain at least 8 characters, " .
            "1 lowercase letter, 1 uppercase letter, and a digit.";
    }
}
