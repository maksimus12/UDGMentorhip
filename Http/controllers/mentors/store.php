<?php

use Core\Validator;
use Core\Database;
use Core\App;

$db = App::resolve(Database::class);
//dd($_POST);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user = $db->query('select * from users where email= :email', [
        'email' => $_POST['mentor_email'],
    ])->find();

    if ($user) {
        $errors['mentor_email'] = 'This email is already taken';
    }

    if (!Validator::email($_POST['mentor_email'])) {
        $errors['mentor_email'] = 'Should be a valid email address';
    }
    if (!Validator::string($_POST['password'], 7, 255)) {
        $errors['password'] = 'Provide a valid password';
    }

    if (!empty($errors)) {
        $mentors = $db->query('SELECT * FROM users')->get();
        view("mentors/index.view.php", [
            'heading' => 'Create student',
            'mentors' => $mentors,
            'errors' => $errors
        ]);
    }

    if (empty($errors)) {
        $db->query('INSERT INTO users(email, password, role) VALUES(:email, :password, :role)', [
            'email' => strtolower($_POST['mentor_email']),
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role' => $_POST['role']
        ]);

        header('Location: /mentors');
        die();
    }
}