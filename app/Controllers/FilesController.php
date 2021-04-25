<?php

namespace App\Controllers;

use App\Services\Photos\ShowPhotoService;
use App\Services\Photos\UploadPhotoRequest;
use App\Services\Photos\SavePhotoService;
use App\Validation\ImageValidator;
use Twig\Environment;

class FilesController
{
    private Environment $twig;
    private SavePhotoService $savePhotoService;
    private ShowPhotoService $showPhotoService;
    private ImageValidator $validator;

    public function __construct(Environment $twig, SavePhotoService $savePhotoService, ShowPhotoService $showPhotoService, ImageValidator $validator)
    {
        $this->twig = $twig;
        $this->savePhotoService = $savePhotoService;
        $this->showPhotoService = $showPhotoService;
        $this->validator = $validator;
    }

    public function upload(): void
    {
        $id = $_SESSION['auth']['id'];

        $this->validator->validate($_FILES);

        if (count($this->validator->getMessages()) === 0) {
            $photo = $this->savePhotoService->prepare($_FILES, $id);
            $this->savePhotoService->save($photo, $id);
            header('Location:/profile/MyGallery/' . $id);

        } else {

            $_SESSION['_flash']['message'] = $this->validator->getMessages()[0];
            header('Location:/profile/MyGallery/' . $id);
        }
    }

    public function showGallery(): void
    {
        $id = $_SESSION['auth']['id'];

        $gallery = $this->showPhotoService->showGallery($id);

        $this->twig->display('UserGalleryView.twig',
            ['gallery' => $gallery, 'id' => $id, 'message' => $_SESSION['_flash']['message']]);
    }


}