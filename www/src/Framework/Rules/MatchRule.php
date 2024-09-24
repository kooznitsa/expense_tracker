<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class MatchRule implements RuleInterface
{
    /*
     * Checks if value matches another field value.
     *
     * Example of usage in ValidatorService: "match:password".
     */
    public function validate(array $formData, string $field, array $params): bool
    {
        return $formData[$field] === $formData[$params[0]];
    }

    public function getMessage(array $formData, string $field, array $params): string
    {
        return "Does not match $params[0] field.";
    }
}
