<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$users = $db->query('SELECT * FROM users')->get();

$userStudents = $db->query('SELECT 
                        students.fname AS student, 
                        GROUP_CONCAT(users.email) AS mentor,
                        students.id AS student_id
                        FROM users_students
                        JOIN students ON users_students.student_id = students.id
                        JOIN users ON users_students.user_id = users.id
                        GROUP BY student_id')->get();


view("students/index.view.php", [
    'heading' => 'Students',
    'users' => $users,
    'userStudents' => $userStudents,
]);