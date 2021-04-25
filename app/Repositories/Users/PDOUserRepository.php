<?php

namespace App\Repositories\Users;


use App\Models\User;
use Dotenv\Dotenv;
use PDO;
use PDOException;

class PDOUserRepository implements UserRepository
{
    private PDO $db;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable('../bootstrap');
        $dotenv->load();
        try {
            $this->db = new PDO('mysql:host=localhost;dbname=tinder', $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage());
        }
        $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function add(User $user): void
    {
        $query = 'INSERT INTO users (username, email, gender, password) VALUES (:username, :email, :gender, :password )';
        $statement = $this->db->prepare($query);
        $params = [
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'gender' => $user->getGender(),
            'password' => $user->getPassword()
        ];
        $statement->execute($params);
    }


    public function getUserByEmail(string $email): ?array
    {
        $query = 'SELECT * FROM users WHERE email = :email';
        $statement = $this->db->prepare($query);
        $statement->bindValue('email', $email);
        $statement->execute();
        $count = $statement->rowCount();
        $count === 1 ? $userData = $statement->fetch() : $userData = null;
        return $userData;

    }


    public function getLoginUserPassword(string $requestEmail): string
    {
        $query = ('SELECT password FROM users WHERE email = :email');
        $statement = $this->db->prepare($query);
        $statement->bindValue('email', $requestEmail);
        $statement->execute();
        return $statement->fetch()['password'];
    }


    public function getByUsernameOrEmail(string $username, string $email): array
    {
        $query = 'SELECT * FROM users WHERE username = :username OR email = :email';
        $statement = $this->db->prepare($query);
        $params = [
            'username' => $username,
            'email' => $email
        ];
        $statement->execute($params);
        return $statement->fetchAll();
    }

}