<?php

use Core\Database;
use Core\App;
use Core\Validator;

$db = App::resolve(Database::class);

$mentor = $db->query('SELECT * FROM users WHERE id = :id', ['id' => $_POST['id']])->find();


$errors = [];

if (!Validator::string($_POST['new-pass'])) {
    $errors['mentor'] = 'Should be a valid pass more than 8 characters';
}

if (!empty($errors)) {
    view("mentors/edit.view.php", [
        'heading' => 'Update mentor',
        'mentor' => $mentor,
        'errors' => $errors
    ]);
    return;
}


$db->query('update users set password = :password  where id = :id', [
    'password' => password_hash($_POST['new-pass'], PASSWORD_DEFAULT),
    'id' => $_POST['id']
]);

header('Location: /mentors');
die();