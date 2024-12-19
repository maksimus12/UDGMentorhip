<?php
use Core\Database;
use Core\App;

$db = App::resolve(Database::class);
//dd($_SESSION['user']['user_id']);
$meetings = $db->query('SELECT 
            posts.id,   
            posts.user_id,
            students.fname,
            posts.topic
            FROM posts
            INNER JOIN users ON posts.user_id = users.id
            INNER JOIN students ON posts.student_id = students.id 
            where posts.user_id = :user_id', [
                'user_id'=> $_SESSION['user']['user_id']
            ])->get();


view("meetings/index.view.php", [
    'heading' => 'My meetings',
    'meetings' => $meetings
]);