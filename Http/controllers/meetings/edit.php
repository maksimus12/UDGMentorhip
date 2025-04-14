<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

if(\Core\Session::isAdmin()){
    $students = $db->query('select * from students')->get();
}else{
    $students = $db->query('SELECT 
                    students.id AS id,
                    students.fname AS fname
                    FROM users_students
                    JOIN students ON users_students.student_id = students.id
                    WHERE users_students.user_id = :id',
        [
            ':id' => Core\Session::getUserId()
        ]
    )->get();
}

$userStudent = $db->query('SELECT 
                students.fname AS student,
                students.id AS student_id
                FROM users_students 
                JOIN students ON users_students.student_id = students.id
                WHERE students.id = :student_id',
    [
        'student_id' => $_GET['id']
    ])->find();

$meeting = $db->query(
    'SELECT 
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
        where meetings.id = :id',
    [
        'id' => $_GET['id'],
    ],
)->findOrFail();


authorize($meeting['user_id'] === \Core\Session::getUserId() || \Core\Session::isAdmin());


view("meetings/edit.view.php", [
    'heading' => 'Edit meeting',
    'errors' => [],
    'meeting' => $meeting,
    'students' => $students,
]);
