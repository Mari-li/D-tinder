<?php

namespace App\Services\Photos;

use App\Models\UserPhoto;
use App\Repositories\Photos\UserPhotosRepository;


class SavePhotoService
{
    private UserPhotosRepository $photoRepository;

    public function __construct(UserPhotosRepository $photoRepository)
    {
        $this->photoRepository = $photoRepository;
    }

    public function prepare(array $vars, int $userId): UploadPhotoRequest
    {
        $name = $vars['fileToUpload']['name'];
        $size = $vars['fileToUpload']['size'];
        $type = $str = trim(substr($vars['fileToUpload']['type'], strrpos($vars['fileToUpload']['type'], '/') + 1));
        $fileName = md5(time() . $userId);
        $targetDir = "../storage/pictures/public";
        $file = $targetDir . '/' . $fileName . '.' . $type;

        if (move_uploaded_file($vars["fileToUpload"]['tmp_name'], $file)) {
            return new UploadPhotoRequest($name, $size, $type, $file);
        }
    }


    public function save(UploadPhotoRequest $request, int $userId)
    {
        $photo = new UserPhoto(
            $request->getName(),
            $request->getSize(),
            $request->getType(),
            $request->getFile()
        );
        $this->photoRepository->add($photo, $userId);
    }




}