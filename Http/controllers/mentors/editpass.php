<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$mentor = $db->query('SELECT * FROM users WHERE id = :id', ['id' => $_GET['id']])->find();

view("mentors/editpass.view.php", [
    'heading' => 'Mentors',
    'mentor' => $mentor
]);