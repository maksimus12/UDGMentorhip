<?php

use Core\Database;
use Core\App;
use Core\Validator;

$db = App::resolve(Database::class);

$mentor = $db->query('SELECT * FROM users WHERE id = :id', ['id' => $_POST['id']])->find();


$errors = [];

if (!Validator::email($_POST['mentor_email'])) {
    $errors['mentor'] = 'Should be a valid email address';
}

if (!empty($errors)) {

    view("mentors/edit.view.php", [
        'heading' => 'Update mentor',
        'mentor' => $mentor,
        'errors' => $errors
    ]);
    return;
}


$db->query('update users set email = :email, role = :role, is_deleted = :is_deleted  where id = :id', [
    'email' => $_POST['mentor_email'],
    'role' => $_POST['role'],
    'is_deleted' => $_POST['status'],
    'id' => $_POST['id']
]);

header('Location: /mentors');
die();