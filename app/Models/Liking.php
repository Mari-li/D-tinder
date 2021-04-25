<?php

namespace App\Models;


class Liking
{
    private int $userId;
    private int $likingUserId;
    private int $likingPhotoId;
    private string $value;

    public function __construct(int $userId, int $likingUserId, int $likingPhotoId, string $value)
    {
        $this->userId = $userId;
        $this->likingUserId = $likingUserId;
        $this->likingPhotoId = $likingPhotoId;
        $this->value = $value;
    }


    public function getUserId(): int
    {
        return $this->userId;
    }


    public function getLikingUserId(): int
    {
        return $this->likingUserId;
    }


    public function getLikingPhotoId(): int
    {
        return $this->likingPhotoId;
    }


    public function getValue(): string
    {
        return $this->value;
    }

}