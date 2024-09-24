<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Validator;
use Framework\Rules\{EmailRule, MatchRule, MaxRule, MinRule, PasswordRule, RequiredRule, UrlRule};

class ValidatorService
{
    public function __construct(
        private Validator $validator = new Validator(),
    ) {
        $this->validator->add("email", new EmailRule());
        $this->validator->add("match", new MatchRule());
        $this->validator->add("max", new MaxRule());
        $this->validator->add("min", new MinRule());
        $this->validator->add("password", new PasswordRule());
        $this->validator->add("required", new RequiredRule());
        $this->validator->add("url", new UrlRule());
    }

    public function validateRegister(array $formData): void
    {
        $this->validator->validate($formData, [
            "email" => ["required", "email"],
            "age" => ["required", "min:18", "max:120"],
            "country" => ["required"],
            "socialMediaURL" => ["required", "url"],
            "password" => ["required", "password"],
            "confirmPassword" => ["required", "match:password"],
            "tos" => ["required"],
        ]);
    }
}
