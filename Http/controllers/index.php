<?php

use Core\Database;
use Core\App;

if (isset($_SESSION['user']) && isset($_SESSION['user']['email'])) {
    $_SESSION['name'] = $_SESSION['user']['email'];
}


$db = App::resolve(Database::class);

if (isset($_SESSION['user'])) {
    $meetingsByMentor = [];
    if ($_SESSION['user']['user_role'] == \Core\UserRoles::ADMIN) {
        $meetings = $db->query('SELECT * FROM meetings')->get();
        $meetingByStudent = $db->query(
            'SELECT 
                students.fname AS studentName, 
                count(meetings.id) AS meetingCount 
                FROM students 
                LEFT JOIN meetings 
                ON students.id = meetings.student_id 
                GROUP BY students.id, students.fname 
                ORDER BY meetingCount DESC',
        )->get();
        $meetingsByMentor = $db->query(
            'SELECT 
                users.email AS username, 
                count(meetings.id) AS meetingCount 
                FROM users 
                LEFT JOIN meetings 
                ON users.id = meetings.user_id 
                GROUP BY users.id, users.email 
                ORDER BY meetingCount DESC',
        )->get();
    } elseif ($_SESSION['user']['user_role'] == \Core\UserRoles::USER) {
        $meetings = $db->query('SELECT * FROM meetings where user_id = :user_id', [
            'user_id' => $_SESSION['user']['user_id'],
        ])->get();
        $meetingByStudent = $db->query(
            'SELECT 
                students.fname AS studentName, 
                count(meetings.id) AS meetingCount 
                FROM students 
                LEFT JOIN meetings 
                ON students.id = meetings.student_id 
                WHERE meetings.user_id = :user_id
                GROUP BY students.id, students.fname 
                ORDER BY meetingCount DESC
                ',
            ['user_id' => $_SESSION['user']['user_id']],
        )->get();
    } else {
        $meetings = [];
    }
}


view("index.view.php", [
    'heading' => 'Home',
    'meetingCount' => count($meetings),
    'meetingByStudent' => $meetingByStudent,
    'meetingsByMentor' => $meetingsByMentor,
]);