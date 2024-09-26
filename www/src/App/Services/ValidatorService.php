<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Validator;
use Framework\Rules\{
    DateFormatRule, EmailRule, LengthMaxRule, MatchRule, MaxRule,
    MinRule, NumericRule, PasswordRule, RequiredRule, UrlRule,
};

class ValidatorService
{
    public function __construct(
        private Validator $validator = new Validator(),
    ) {
        $this->validator->add("date", new DateFormatRule());
        $this->validator->add("email", new EmailRule());
        $this->validator->add("lengthMax", new LengthMaxRule());
        $this->validator->add("match", new MatchRule());
        $this->validator->add("max", new MaxRule());
        $this->validator->add("min", new MinRule());
        $this->validator->add("numeric", new NumericRule());
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

    public function validateLogin(array $formData): void
    {
        $this->validator->validate($formData, [
            "email" => ["required", "email"],
            "password" => ["required", "password"],
        ]);
    }

    public function validateTransaction(array $formData): void
    {
        $this->validator->validate($formData, [
            "description" => ["required", "lengthMax:255"],
            "amount" => ["required", "numeric"],
            "date" => ["required", "date:Y-m-d"],
        ]);
    }

    public function validateFile(?array $file): void
    {
        $this->validator->validateFile($file);
    }
}
