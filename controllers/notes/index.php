<?php
use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$notes = $db->query('SELECT 
            posts.id,   
            students.fname,
            posts.topic
            FROM posts
            INNER JOIN users ON posts.user_id = users.id
            INNER JOIN students ON posts.student_id = students.id; 
            where user_id = 1')->get();


view("notes/index.view.php", [
    'heading' => 'My Notes',
    'notes' => $notes
]);