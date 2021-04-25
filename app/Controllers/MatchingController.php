<?php


namespace App\Controllers;


use App\Services\Matching\MatchingService;
use Twig\Environment;

class MatchingController
{
    private Environment $twig;
    private MatchingService $matchingService;

    public function __construct(Environment $twig, MatchingService $matchingService)
    {
        $this->twig = $twig;
        $this->matchingService = $matchingService;
    }


    public function selectMatches(): void
    {
        var_dump($_SESSION);
        $gender = $_SESSION['gender'];
        $id = $_SESSION['auth']['id'];
        $gallery = $this->matchingService->selectMatching($id, $gender);
        $this->twig->display('MatchingView.twig', ['photos' => $gallery, 'id' => $id]);
    }


    public function showMatches(): void
    {
        $id = $_SESSION['auth']['id'];
        $this->matchingService->prepareMatches($id);
    }


}