<?php

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class DateFormatRule implements RuleInterface
{
    /*
     * Checks if date corresponds to the given format.
     *
     * Example of usage in ValidatorService: "date:Y-m-d".
     */
    public function validate(array $formData, string $field, array $params): bool
    {
        $parsedDate = date_parse_from_format($params[0], $formData[$field]);

        return $parsedDate["error_count"] === 0 && $parsedDate["warning_count"] === 0;
    }

    public function getMessage(array $formData, string $field, array $params): string
    {
        return "Invalid date.";
    }
}
