<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);


$currentUserId = $_SESSION['user']['user_id'];



    $meeting = $db->query('SELECT 
                        meetings.id as post_id,
                        students.id as student_id,
                        users.id as user_id,
                        students.fname,
                        meetings.topic,
                        meetings.body,
                        meetings.meeting_datetime
                        FROM meetings
                        INNER JOIN users ON meetings.user_id = users.id
                        INNER JOIN students ON meetings.student_id = students.id
                        where meetings.id = :id', [
                        'id' => $_GET['id']
    ])->findOrFail();
    
    authorize($meeting['user_id'] === $currentUserId);


view("meetings/edit.view.php", [
    'heading' => 'Edit meeting',
    'errors' => [],
    'meeting' => $meeting
]);
