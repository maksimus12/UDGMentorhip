<?php

namespace Http\controllers;

use Core\Authenticator;
use Core\Session;
use Http\Forms\LoginForm;

class LoginController
{
    public function index()
    {
        view('sessions/create.view.php', [
            'errors' => Session::get('errors'),
        ]);
    }

    public function login()
    {
        $form = LoginForm::make(
            $attributes = [
                'email' => $_POST['email'],
                'password' => $_POST['password'],
            ],
        );
        $signedIn = (new Authenticator)->attempt(
            $attributes['email'],
            $attributes['password'],
        );

        if (!$signedIn) {
            $form
                ->error('email', "Wrong email or password")
                ->throw();
        }

        redirect('/');
    }

    public function logout()
    {
        Authenticator::logout();
        header('Location: /');
        exit();
    }
}