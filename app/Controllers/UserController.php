<?php


namespace App\Controllers;

use App\Services\Users\RegistrationUserRequest;
use App\Services\Users\LoginUserService;
use App\Services\Users\UserRegistrationService;
use App\Validation\UserValidator;
use App\Validation\UserValidatorInterface;
use Twig\Environment;

class UserController
{
    private Environment $twig;
    private UserRegistrationService $registerUserService;
    private LoginUserService $loginService;
    private UserValidatorInterface $validator;

    public function __construct(Environment $twig, UserRegistrationService $registerUserService, LoginUserService $loginService, UserValidatorInterface $validator)
    {
        $this->twig = $twig;
        $this->registerUserService = $registerUserService;
        $this->loginService = $loginService;
        $this->validator = $validator;
    }

    public function registrationForm(): void
    {
        if (isset($_SESSION['_flash']['message'])) {
            $message = $_SESSION['_flash']['message'];
        }
        $this->twig->display('RegistrationView.twig', ['message' => $message]);
    }



    public function register(): void
    {

    //    $this->twig->display('RegistrationView.twig', ['message' => $message]);

            $newUser = new RegistrationUserRequest(
                $_POST['username'],
                $_POST['email'],
                $_POST['gender'],
                $_POST['password'],
                $_POST['password_confirmation'],
            );

            $this->validator->validate($newUser);
            $messages = $this->validator->getErrors();
            if (count($messages) === 0) {

                $this->registerUserService->store($newUser);

                $_SESSION['_flash']['message'] = 'You are successfully registered. Log into your account';
                header('Location:/login');
            } else{
                $_SESSION['_flash']['message'] = $messages[0];
                header('Location:/register');
            }

    }


    public function loginForm(): void
    {
        if (isset($_SESSION['_flash']['message'])) {
            $message =  $_SESSION['_flash']['message'];
        }
        $this->twig->display('LoginView.twig', ['message' => $message]);
    }


    public function loginUser(): void
    {
        $requestEmail = $_POST['email'];
        $requestPassword = $_POST['password'];

        $user = $this->loginService->checkLogin($requestEmail, $requestPassword);

        $_SESSION['_flash']['message'] = $this->loginService->getErrors();

        $_SESSION['auth']['id'] = $user->getId();
        $_SESSION['auth']['username'] = $user->getUsername();
        $_SESSION['gender'] = $user->getGender();

        header('Location:/profile/' . $user->getId());

    }

    public function showProfile(): void
    {
        $username = $_SESSION['username'];
        $id = $_SESSION['auth']['id'];
        $this->twig->display('ProfileView.twig', ['username' => $username, 'id' => $id]);
    }


    public function logout(): void
    {
        session_start();
        unset($_SESSION['auth']);
        header('Location:/');
    }


}