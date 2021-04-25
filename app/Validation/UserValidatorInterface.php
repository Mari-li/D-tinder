<?php


namespace App\Validation;


use App\Services\Users\RegistrationUserRequest;

interface UserValidatorInterface
{
    public function validate(RegistrationUserRequest $request): void;

    public function getErrors(): array;

}