<?php

namespace App\Repositories\Users;


use App\Models\User;

interface UserRepository
{
    public function add(User $user): void;

    public function getUserByEmail(string $email): ?array;

    public function getLoginUserPassword(string $requestEmail): string;

    public function getByUsernameOrEmail(string $username, string $email): ?array;


}