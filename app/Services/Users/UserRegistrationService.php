<?php


namespace App\Services\Users;


use App\Repositories\Users\UserRepository;
use App\Models\User;

class UserRegistrationService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

    }

    public function store(RegistrationUserRequest $request): User
    {
        $user = new User(
            null,
            $request->getUsername(),
            $request->getEmail(),
            $request->getGender(),
            $request->getPassword()
        );

        $this->userRepository->add($user);
        return $user;
    }


}