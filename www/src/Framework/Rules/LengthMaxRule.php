<?php

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;
use InvalidArgumentException;

class LengthMaxRule implements RuleInterface
{
    /*
     * Checks if text does not exceed specified length.
     *
     * Example of usage in ValidatorService: "lengthMax:255".
     */
    public function validate(array $formData, string $field, array $params): bool
    {
        if (empty($params[0])) {
            throw new InvalidArgumentException("Maximum length not specified.");
        }

        $length = (int) $params[0];

        return strlen($formData[$field]) < $length;
    }

    public function getMessage(array $formData, string $field, array $params): string
    {
        return "Exceeds maximum character limit of $params[0] characters.";
    }
}
