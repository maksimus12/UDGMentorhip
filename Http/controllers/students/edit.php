<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$students = $db->query('SELECT * FROM students WHERE id = :id', ['id' => $_GET['id']])->find();

view("students/edit.view.php", [
    'heading' => 'Students',
    'student' => $students
]);