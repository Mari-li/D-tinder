<?php

namespace App\Middlewares;

class AuthMiddleware implements MiddlewareInterface
{

    public function handle(): void
    {
        if(! isset($_SESSION['auth'])){
            header('Location:/login');
        }
    }
}
