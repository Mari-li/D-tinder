<?php

namespace App\Repositories\Liking;

use App\Models\Liking;
use App\Models\UserPhoto;

interface LikingRepository
{
    public function add(Liking $liking): void;

    public function getDislikedPhotos(int $userId): ?array;

    public function getLikedUsers(int $userId): ?array;

    public function getUsersWhoLiked(int $userId): ?array;
}