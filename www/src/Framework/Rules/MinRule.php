<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use InvalidArgumentException;

class MinRule implements RuleInterface
{
    /*
     * Checks if integer value is more or equal to specified integer.
     *
     * Example of usage in ValidatorService: "min:18".
     */
    public function validate(array $formData, string $field, array $params): bool
    {
        if (empty($params[0])) {
            throw new InvalidArgumentException("Minimum length not specified.");
        }

        $length = (int) $params[0];

        return $formData[$field] >= $length;
    }

    public function getMessage(array $formData, string $field, array $params): string
    {
        return "Must be at least $params[0].";
    }
}
