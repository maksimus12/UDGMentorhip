<?php

use Core\App;
use Core\Database;
use Core\Validator;

$email = $_POST['email'];
$password = $_POST['password'];

//Validate email
$errors = [];

if(!Validator::email($email)){
    $errors['email'] = 'Provide a valid email';
}

if(!Validator::string($password, 7, 255)){
    $errors['password'] = 'Provide a valid password';
}

if(!empty($errors)){
    return view('registration/create.view.php', [
        'errors' => $errors
    ]);
}

$db = App::resolve(Database::class);

$user = $db->query('select * from users where email= :email', [
    'email' => $email
])->find();

if($user){
    header('Location: /');
    exit();
}else{
    $db->query('INSERT INTO users(email, password) VALUES(:email, :password)', [
        'email'=>$email,
        'password' => password_hash($password, PASSWORD_DEFAULT)
    ]);

    $_SESSION['user'] = [
        'email' => $email
    ];

    header('Location: /');
    exit();
}