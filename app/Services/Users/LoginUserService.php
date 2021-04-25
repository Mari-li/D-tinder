<?php


namespace App\Services\Users;


use App\Models\User;
use App\Repositories\Users\UserRepository;

class LoginUserService
{
    private UserRepository $userRepository;
    private array $errors = [];

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function checkLogin(string $requestEmail, string $requestPassword): ?User
    {
        if (!is_null($this->userRepository->getUserByEmail($requestEmail))) {
            $userData = $this->userRepository->getUserByEmail($requestEmail);
            if (password_verify($requestPassword, $this->userRepository->getLoginUserPassword($requestEmail))) {
                $user = new User(
                    $userData['id'],
                    $userData['username'],
                    $userData['email'],
                    $userData['gender'],
                    $userData['password']
                );
            } else {
                $this->errors[] = 'Invalid password!';
            }
        } else $this->errors[] = 'User with this email is not registered in Tinder';
        return $user;
    }


    public function getErrors(): array
    {
        return $this->errors;
    }


}