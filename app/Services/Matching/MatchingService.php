<?php

namespace App\Services\Matching;

use App\Repositories\Liking\LikingRepository;
use App\Repositories\Photos\UserPhotosRepository;

class MatchingService
{
    private UserPhotosRepository $photoRepository;
    private LikingRepository $likingRepository;

    public function __construct(UserPhotosRepository $photoRepository, LikingRepository $likingRepository)
    {
        $this->photoRepository = $photoRepository;
        $this->likingRepository = $likingRepository;
    }


    public function selectMatching($userId, string $gender): array
    {
        $photos = $this->photoRepository->getAllByGender($gender);
        $dislikedPhotos = $this->likingRepository->getDislikedPhotos($userId);

        $photosForMatching = [];

        foreach ($photos as $photoId => $file) {
            if (!in_array($photoId, $dislikedPhotos)) {
                $photosForMatching[] = $file;
            }
        }
        return $photosForMatching;
    }

    public function prepareMatches(int $userId): ?array
    {
        $userLikes = $this->likingRepository->getLikedUsers($userId);
        $likesUser = $this->likingRepository->getUsersWhoLiked($userId);

        $perfectMarches = [];

        foreach ($userLikes as $like) {
            if (in_array($like, $likesUser)) {
                $perfectMarches[] = $like;
            }
        }
        return $perfectMarches;
    }

}