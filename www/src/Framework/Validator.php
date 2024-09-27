<?php

declare(strict_types=1);

namespace Framework;

use Framework\Contracts\RuleInterface;
use Framework\Exceptions\ValidationException;

class Validator
{
    private array $rules = [];

    public function add(string $alias, RuleInterface $rule): void
    {
        $this->rules[$alias] = $rule;
    }

    public function validate(array $formData, array $fields): void
    {
        $errors = [];

        foreach ($fields as $fieldName => $rules) {
            foreach ($rules as $rule) {
                $ruleParams = [];

                if (str_contains($rule, ":")) {
                    [$rule, $ruleParams] = explode(":", $rule);
                    $ruleParams = explode(",", $ruleParams);
                }

                $ruleValidator = $this->rules[$rule];

                if ($ruleValidator->validate($formData, $fieldName, $ruleParams)) {
                    continue;
                }

                $errors[$fieldName][] = $ruleValidator->getMessage($formData, $fieldName, $ruleParams);
            }
        }

        if (count($errors)) {
            throw new ValidationException($errors);
        }
    }

    public function validateFile(?array $file): void
    {
        if (!$file || $file["error"] !== UPLOAD_ERR_OK) {
            throw new ValidationException(["receipt" => ["Failed to upload file."]]);
        }

        $maxFileSizeMB = 3 * 1024 * 1024;

        if ($file["size"] > $maxFileSizeMB) {
            throw new ValidationException(
                ["receipt" => ["File upload exceeds the maximum allowed file size of 3 MB."]]
            );
        }

        if (!preg_match("/^[A-Za-z0-9\s._-]+$/", $file["name"])) {
            throw new ValidationException(["receipt" => ["Invalid file name."]]);
        }

        $allowedMimeTypes = ["image/jpeg", "image/png", "application/pdf"];

        if (!in_array($file["type"], $allowedMimeTypes)) {
            throw new ValidationException(["receipt" => ["Invalid file type."]]);
        }
    }
}
