<?php


namespace App\Models;


class UserCollection
{
    /**
     * @var User[]
     */
    private array $users = [];


    public function add(User $user): void
    {
        $this->users[] = $user;
    }

    public function all(): array
    {
        return $this->users;
    }

    public function one(string $username): ?User
    {
        foreach ($this->users as $oneUser) {
            if ($oneUser->getUsername() === $username) {
                $user = $oneUser;
            }
        }
        return $user;
    }

}