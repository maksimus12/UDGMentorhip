<?php

use Core\Database;
use Core\App;
use Core\Validator;

$db = App::resolve(Database::class);

$errors = [];

if (!Validator::string($_POST['fname'], 1, 1000)) {
    $errors['name'] = 'A Name of no more than 1,000 and no less then 1 characters is required.';
}

$db->query('update students set fname = :fname where id = :id', [
        'fname' => $_POST['student_name'],
        'id' => $_POST['id']
    ]);

header('Location: /students');
die();