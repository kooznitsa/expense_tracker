<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class InRule implements RuleInterface
{
    /*
     * Checks if provided value is in specified array.
     *
     * Example of usage in ValidatorService: "in:USA,Canada,Mexico".
     */
    public function validate(array $formData, string $field, array $params): bool
    {
        return in_array($formData[$field], $params);
    }

    public function getMessage(array $formData, string $field, array $params): string
    {
        return "Invalid selection.";
    }
}
