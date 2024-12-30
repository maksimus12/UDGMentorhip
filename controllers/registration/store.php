<?php

use Core\App;
use Core\Database;
use Core\Validator;
use Core\UserRoles;

$email = $_POST['email'];
$password = $_POST['password'];

$db = App::resolve(Database::class);

$user = $db->query('select * from users where email= :email', [
    'email' => $email
])->find();
//Validate email
$errors = [];

if(!Validator::email($email)){
    $errors['email'] = 'Provide a valid email';
}

if(!Validator::string($password, 7, 255)){
    $errors['password'] = 'Provide a valid password';
}

if($user) {
    $errors['email'] = 'This email is already taken';
}
if(!empty($errors)){
    return view('registration/create.view.php', [
        'errors' => $errors
    ]);
} else{
    $db->query('INSERT INTO users(email, password, role) VALUES(:email, :password, :role)', [
        'email'=>$email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'role' => UserRoles::USER
    ]);

    header('Location: /login');
    exit();
}
