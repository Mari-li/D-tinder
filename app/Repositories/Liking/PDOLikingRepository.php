<?php

namespace App\Repositories\Liking;

use App\Models\Liking;
use Dotenv\Dotenv;
use PDO;
use PDOException;

class PDOLikingRepository implements LikingRepository
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


    public function add(Liking $liking): void
    {
        $query = 'INSERT INTO likes (user_id, liking_user_id, liking_photo_id, value) VALUES (:userId, :likingUserId, :likingPhotoId, :value)';
        $statement = $this->db->prepare($query);
        $params = [
            'userId' => $liking->getUserId(),
            'likingUserId' => $liking->getLikingUserId(),
            'likingPhotoId' => $liking->getLikingPhotoId(),
            'value' => $liking->getValue(),
        ];
        $statement->execute($params);
    }

    public function getDislikedPhotos(int $userId): ?array
    {
        $query = 'SELECT liking_photo_id FROM likes WHERE user_id = :userId AND value = :value';
        $statement = $this->db->prepare($query);
        $params =
            [
                'userId' => $userId,
                'value' => 'dislike'
            ];
        $statement->execute($params);
        return $statement->fetchAll()[0];
    }

    public function getLikedUsers(int $userId): ?array
    {
        $query = 'SELECT liking_user_id FROM likes WHERE user_id = :userId AND value = :value';
        $statement = $this->db->prepare($query);
        $params =
            [
                'userId' => $userId,
                'value' => 'like'
            ];
        $statement->execute($params);
        return $statement->fetchAll()[0];
    }

    public function getUsersWhoLiked(int $userId): ?array
    {
        $query = 'SELECT user_id FROM likes WHERE liking_user_id = :userId AND value = :value';
        $statement = $this->db->prepare($query);
        $params =
            [
                'userId' => $userId,
                'value' => 'like'
            ];
        $statement->execute($params);

        return $statement->fetchAll()[0];
    }

}