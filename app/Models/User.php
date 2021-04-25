<?php
namespace App\Models;

class User
{
    private ?int $id;
    private string $username;
    private string $email;
    private string $gender;
    private string $password;

    public function __construct(?int $id, string $username, string $email, string $gender, string $password)
    {

        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->gender = $gender;
        $this->setPassword($password);
    }


    public function getId(): int
    {
        return $this->id;
    }


    public function getUsername(): string
    {
        return $this->username;
    }


    public function getEmail(): string
    {
        return $this->email;
    }


    public function getGender(): string
    {
        return $this->gender;
    }


    public function getPassword(): string
    {
        return $this->password;
    }


    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
}