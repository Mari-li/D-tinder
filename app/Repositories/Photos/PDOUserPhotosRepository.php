<?php


namespace App\Repositories\Photos;


use App\Models\UserPhoto;
use Dotenv\Dotenv;
use PDO;
use PDOException;

class PDOUserPhotosRepository implements UserPhotosRepository
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
        $this->db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }


    public function add(UserPhoto $photo, int $userId): void
    {
        $query = 'INSERT INTO photos (user_id, name, size, type, file) VALUES (:userId, :name, :size, :type, :file )';
        $statement = $this->db->prepare($query);
        $params = [
            'userId' => $userId,
            'name' => $photo->getName(),
            'size' => $photo->getSize(),
            'type' => $photo->getType(),
            'file' => $photo->getFile()
        ];
       $statement->execute($params);
    }

    public function getIDs($file): array
    {
        $query = 'SELECT id, user_id FROM photos WHERE file LIKE :file';
        $statement = $this->db->prepare($query);
        $statement->bindValue('file', $file);
        $statement->execute();
        $IDs = $statement->fetchAll()[0];
        return $IDs;
    }

    public function getAllByUserId(int $userId): array
    {
        $query = 'SELECT file FROM photos WHERE user_id = :userId';
        $statement = $this->db->prepare($query);
        $statement->bindValue('userId', $userId);
        $statement->execute();
        return $statement->fetchAll();
        }

        public function getAllByGender(string $gender): array
        {
            $query = 'SELECT id, file FROM photos WHERE user_id = ANY (SELECT id FROM users WHERE gender <> :gender)  ';
            $statement = $this->db->prepare($query);
            $statement->bindValue('gender', $gender);
            $statement->execute();
            $photos = $statement->fetchAll();
            $gallery = [];

            foreach ($photos as $photo)
            { $file = basename($photo ['file']);
            $id = $photo['id'];
                $gallery[$id] =  $file;
            }
            return $gallery;
        }



}