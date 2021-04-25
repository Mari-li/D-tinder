<?php


namespace App\Services\Photos;


use App\Repositories\Photos\UserPhotosRepository;
use  Intervention\Image\ImageManager;

class ShowPhotoService
{
    private UserPhotosRepository $photoRepository;
    private ImageManager $photoManager;

    public function __construct(UserPhotosRepository $photoRepository)
    {
        $this->photoRepository  = $photoRepository;
        $this->photoManager = new ImageManager(array('driver' => 'imagick'));
    }


    public function showGallery($userId): array
    {
        $photos = $this->photoRepository->getAllByUserId($userId);
        $gallery = [];

        foreach ($photos as $photo)
        {
            $file = basename($photo ["file"]);
            $gallery[] = $file;
        }
        return $gallery;
    }

}