<?php

use Core\Authenticator;
use Http\Forms\LoginForm;


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
