<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

if (Core\Session::isAdmin()){
    $students = $db->query('SELECT * FROM students')->get();
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




view("meetings/create.view.php", [
    'students' => $students,
    'heading' => 'Create meeting',
    'errors' => []
]);
