<?php

use App\Controllers\FilesController;
use App\Controllers\HomeController;
use App\Controllers\LikingController;
use App\Controllers\MatchingController;
use App\Controllers\UserController;
use App\Repositories\Liking\LikingRepository;
use App\Repositories\Liking\PDOLikingRepository;
use App\Repositories\Users\PDOUserRepository;
use App\Repositories\Photos\PDOUserPhotosRepository;
use App\Repositories\Photos\UserPhotosRepository;
use App\Repositories\Users\UserRepository;
use App\Services\Liking\LikingService;
use App\Services\Matching\MatchingService;
use App\Services\Photos\SavePhotoService;
use App\Services\Photos\ShowPhotoService;
use App\Services\Users\LoginUserService;
use App\Services\Users\UserRegistrationService;
use App\Validation\ImageValidator;
use App\Validation\UserValidator;
use App\Validation\UserValidatorInterface;
use League\Container\Container;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$container = new Container;
$container->add(ImageValidator::class);
$container->add(UserValidatorInterface::class, UserValidator::class)->addArgument(UserRepository::class);
$container->add(UserPhotosRepository::class, PDOUserPhotosRepository::class);
$container->add('template', new Environment(new FilesystemLoader('../public/Views')));
$container->add(UserRepository::class, PDOUserRepository::class);
$container->add(HomeController::class)->addArgument('template');
$container->add(FilesController::class)->addArguments([
    'template',
    SavePhotoService::class,
    ShowPhotoService::class,
    ImageValidator::class]);
$container->add(UserController::class)->addArguments([
    'template',
    UserRegistrationService::class,
    LoginUserService::class,
    UserValidatorInterface::class
]);
$container->add(LikingController::class)->addArguments(['template', LikingService::class]);
$container->add(MatchingController::class)->addArguments(['template', MatchingService::class]);
$container->add(UserRegistrationService::class)->addArgument(UserRepository::class);
$container->add(LoginUserService::class)->addArgument(UserRepository::class);
$container->add(SavePhotoService::class)->addArgument(UserPhotosRepository::class);
$container->add(ShowPhotoService::class)->addArgument(UserPhotosRepository::class);
$container->add(MatchingService::class)->addArguments([UserPhotosRepository::class, LikingRepository::class]);
$container->add(LikingService::class)->addArguments([LikingRepository::class, UserPhotosRepository::class]);
$container->add(LikingRepository::class, PDOLikingRepository::class);


return $container;