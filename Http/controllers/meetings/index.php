<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);
//dd($_SESSION['user']['user_role']);

if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['user_role'] == \Core\UserRoles::ADMIN) {
        $meetings = $db->query(
            'SELECT 
                meetings.id,   
                meetings.meeting_datetime,
                meetings.user_id,
                students.fname,
                users.email,
                meetings.topic
                FROM meetings
                INNER JOIN users ON meetings.user_id = users.id
                INNER JOIN students ON meetings.student_id = students.id',
        )->get();
    } else {
        $meetings = $db->query(
            'SELECT 
                meetings.id,   
                meetings.meeting_datetime,
                meetings.user_id,
                students.fname,
                meetings.topic
                FROM meetings
                INNER JOIN users ON meetings.user_id = users.id
                INNER JOIN students ON meetings.student_id = students.id 
                where meetings.user_id = :user_id',
            [
                'user_id' => $_SESSION['user']['user_id'],
            ],
        )->get();
    }
}


view("meetings/index.view.php", [
    'heading' => 'My meetings',
    'meetings' => $meetings,
]);