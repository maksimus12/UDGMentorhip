<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$meeting = $db->query(
    'SELECT 
                        meetings.id as post_id,
                        meetings.created_at as created_at,
                        students.id as student_id,
                        users.id as user_id,
                        users.email as email,
                        students.fname,
                        meetings.topic,
                        meetings.body
                        FROM meetings
                        INNER JOIN users ON meetings.user_id = users.id
                        INNER JOIN students ON meetings.student_id = students.id
                        where meetings.id = :id',
    [
        'id' => $_GET['id'],
    ],
)->findOrFail();

authorize($meeting['user_id'] === \Core\Session::getUserId() || \Core\Session::isAdmin());

view("meetings/show.view.php", [
    'heading' => 'Meeting',
    'meeting' => $meeting,
]);

