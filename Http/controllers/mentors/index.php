<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$mentors = $db->query('SELECT * FROM users')->get();


view("mentors/index.view.php", [
    'heading' => 'Mentors',
    'mentors' => $mentors
]);