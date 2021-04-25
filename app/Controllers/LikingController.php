<?php


namespace App\Controllers;


use App\Services\Liking\LikingService;
use App\Services\Matching\MatchingService;
use Twig\Environment;

class LikingController
{
    private Environment $twig;
    private LikingService $likingService;

    public function __construct(Environment $twig, LikingService $likingService)
    {
        $this->twig = $twig;
        $this->likingService = $likingService;
    }

    public function saveLike()
    {
        $user = $_SESSION['auth']['id'];
        $liking = key($_POST);
        $file= '../storage/pictures/public/' . $_POST[$liking];
        $this->likingService->storeLiking($user, $liking, $file);
        header('Location:/matching/' . $_SESSION['auth']['username']);
    }


}