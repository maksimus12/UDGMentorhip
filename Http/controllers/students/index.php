<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$users = $db->query('SELECT * FROM users')->get();

$userStudents = $db->query("
        SELECT
            students.fname AS student, 
            COALESCE(GROUP_CONCAT(users.email), 'No mentor') AS mentor,
            students.id AS student_id
        FROM students
        LEFT JOIN users_students ON students.id = users_students.student_id
        LEFT JOIN users ON users_students.user_id = users.id
        GROUP BY students.id
        ")->get();

view("students/index.view.php", [
    'heading' => 'Students',
    'users' => $users,
    'userStudents' => $userStudents,
]);
