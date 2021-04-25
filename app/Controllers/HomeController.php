<?php
namespace App\Controllers;

use Twig\Environment;

class HomeController
{

    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function index():void
    {
        if(isset($_SESSION['auth']))
        {
            $id = $_SESSION['auth']['id'];
            $name = $_SESSION['auth']['username'];
        }

        $this->twig->display('HomeView.twig', ['id' => $id, 'name' => $name]);
    }

}