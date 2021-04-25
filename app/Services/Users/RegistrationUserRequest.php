<?php

namespace App\Services\Users;


class RegistrationUserRequest
{
    private string $username;
    private string $email;
    private string $gender;
    private string $password;
    private string $passwordConfirmation;

    public function __construct(string $username, string $email, string $gender, string $password, string $passwordConfirmation)
    {

        $this->username = $username;
        $this->email = $email;
        $this->gender = $gender;
        $this->password = $password;
        $this->passwordConfirmation = $passwordConfirmation;
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


    public function getPasswordConfirmation(): string
    {
        return $this->passwordConfirmation;
    }

}