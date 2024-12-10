<?php
use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$students = $db->query('SELECT * FROM students')->get();

view("notes/create.view.php", [
    'students' => $students,
    'heading' => 'Create Note',
    'errors' => []
]);
