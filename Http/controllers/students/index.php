<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$students = $db->query('SELECT * FROM students')->get();


view("students/index.view.php", [
    'heading' => 'Students',
    'students' => $students
]);