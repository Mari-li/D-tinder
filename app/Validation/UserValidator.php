<?php

namespace App\Validation;

use App\Repositories\Users\UserRepository;
use App\Services\Users\RegistrationUserRequest;
use Respect\Validation\Validator as v;

class UserValidator implements UserValidatorInterface
{

    private array $errors = [];
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    private function checkPasswordConfirmation(string $password, string $passwordConfirm): void
    {
        if ($password !== $passwordConfirm) {
            $this->errors[] = 'Password confirmation donn\'t much password!';
        }
    }

    private function checkIfUsernameOrEmailExists(string $username, string $password)
    {
        if (count($this->userRepository->getByUsernameOrEmail($username, $password)) > 0) {
            $this->errors[] = 'User with this email or username already exists in Tinder!';
        }
    }

    public function validate(RegistrationUserRequest $request): void
    {
        $userValidator =
            v::attribute('username', v::alnum()->length(3, 32)->noWhitespace())
                ->attribute('email', v::email())
                ->attribute('gender', v::alpha()->oneOf(v::equals('male'), v::equals('female')))
                ->attribute('password', v::length(8, 20)->noWhitespace());

        try {
            $userValidator->check($request);
            $this->checkPasswordConfirmation($request->getPassword(), $request->getPasswordConfirmation());
            $this->checkIfUsernameOrEmailExists($request->getUsername(), $request->getEmail());
        } catch (\InvalidArgumentException $e) {
            $this->errors[] = $e->getMessage();
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }


}