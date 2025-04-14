<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$allUsers = $db->query('SELECT * FROM users')->get();

$userStudent = $db->query('SELECT 
                students.fname AS student,
                students.id AS student_id
                FROM students 
                WHERE students.id = :student_id',
                [
                    'student_id' => $_GET['id']
                ])->find();

$mentors = $db->query('SELECT 
                users.id AS user_id,
                users.email AS mentor_email
                FROM users_students 
                JOIN users ON users_students.user_id = users.id
                WHERE users_students.student_id = :student_id',
                [
                    'student_id' => $_GET['id']
                ])->get();


$mentorIds = array_column($mentors, 'user_id');

view("students/edit.view.php", [
    'heading' => 'Students',
//    'student' => $students,
    'allUsers' => $allUsers,
    'userStudent' => $userStudent,
    'mentors' => $mentors,
    'mentorIds' => $mentorIds
]);