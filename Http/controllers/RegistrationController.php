<?php

namespace Http\controllers;

use Core\App;
use Core\Session;
use Http\Forms\RegistrationForm;
use Http\models\UserModel;


class RegistrationController
{
    public function index()
    {
        $errors = Session::get('errors', []);
        return view("registration/create.view.php", [
            'errors' => $errors,
        ]);
    }

    public function register()
    {
        /* @var UserModel $userModel */
        $userModel = App::resolve(UserModel::class);

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $userModel->findUserByEmail($email);

        $attributes = [
            'email' => $email,
            'password' => $password,
            'user' => $user,
        ];


        RegistrationForm::make($attributes);

        $userModel->createNewUser($email, $password);
        header('Location: /login');
        exit();
    }
}