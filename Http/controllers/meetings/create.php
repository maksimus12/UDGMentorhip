<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$students = $db->query('SELECT * FROM students')->get();

view("meetings/create.view.php", [
    'students' => $students,
    'heading' => 'Create meeting',
    'errors' => []
]);
