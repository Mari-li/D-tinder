<?php


namespace App\Models;


class UserPhotoCollection
{
    /**
     * @var UserPhoto []
     */
    private array $photos;

    public function add(UserPhoto $photo): void
    {
        $this->photos[] = $photo;
    }

    public function all(): array
    {
        return $this->photos;
    }



}