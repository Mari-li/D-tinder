<?php

use App\Controllers\FilesController;
use App\Controllers\HomeController;
use App\Controllers\LikingController;
use App\Controllers\MatchingController;
use App\Controllers\UserController;
use App\Middlewares\AuthMiddleware;

$container = require_once '../bootstrap/container.php';

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', [HomeController::class, 'index']);
    $r->addRoute('POST', '/register', [UserController::class, 'register']);
    $r->addRoute('GET', '/register', [UserController::class, 'registrationForm']);
    $r->addRoute('GET', '/login', [UserController::class, 'loginForm']);
    $r->addRoute('GET', '/profile/[{id:\d+}]', [UserController::class, 'showProfile']);
    $r->addRoute('GET', '/profile/MyGallery/[{id:\d+}]', [FilesController::class, 'showGallery']);
    $r->addRoute('POST', '/profile/MyGallery/[{id:\d+}]', [FilesController::class, 'upload']);
    $r->addRoute('POST', '/login/user', [UserController::class, 'loginUser']);
    $r->addRoute('GET', '/matching/[{id:\d+}]', [MatchingController::class, 'selectMatches']);
    $r->addRoute('POST', '/matching/photo/[{id:\d+}]', [MatchingController::class, 'selectMatches']);
    $r->addRoute('GET', '/cupid-page/[{id:\d+}]', [MatchingController::class, 'showMatches']);
    $r->addRoute('GET', '/logout', [UserController::class, 'logout']);


});


$middlewares = [
    UserController::class . '@showProfile' => [
        AuthMiddleware::class
    ],
    FilesController::class . '@showGallery' => [
        AuthMiddleware::class
    ],
    MatchingController::class . '@showMatches' => [
        AuthMiddleware::class
    ],
    MatchingController::class . '@selectMatches' => [
        AuthMiddleware::class
    ],

];


$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        [$controller, $method] = $handler;

        $middlewareKey = $controller . '@' . $method;
        $controllerMiddlewares = $middlewares[$middlewareKey] ?? [];

        foreach ($controllerMiddlewares as $controllerMiddleware) {
            (new $controllerMiddleware)->handle();
        }

        echo ($container->get($controller))->$method($vars);
        break;
}

