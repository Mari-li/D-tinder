<?php

namespace App\Repositories\Photos;

use App\Models\UserPhoto;

interface UserPhotosRepository
{
    public function add(UserPhoto $photo, int $userId): void;

    public function getIDs($file): array;

    public function getAllByGender(string $gender):array;
}