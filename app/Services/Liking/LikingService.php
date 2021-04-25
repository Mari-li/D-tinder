<?php

namespace App\Services\Liking;

use App\Models\Liking;
use App\Repositories\Liking\LikingRepository;
use App\Repositories\Photos\UserPhotosRepository;

class LikingService
{

    private LikingRepository $likingRepository;
    private UserPhotosRepository $photosRepository;

    public function __construct(LikingRepository $likingRepository, UserPhotosRepository $photosRepository)
    {
        $this->likingRepository = $likingRepository;
        $this->photosRepository = $photosRepository;
    }


    public function storeLiking($userId, $value, $file): void
    {
        $likingUserId = $this->photosRepository->getIDs($file)['user_id'];
        $likingPhotoId = $this->photosRepository->getIDs($file)['id'];

        $liking = new Liking($userId, $likingUserId, $likingPhotoId, $value);

        $this->likingRepository->add($liking);
    }

}