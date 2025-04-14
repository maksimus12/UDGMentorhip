<?php

use Http\Forms\AddStudentForm;
use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$errors = [];
$mentors = $_POST['mentor'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $form = AddStudentForm::validate(
        $attributes = [
            'student_name'=> $_POST['student_name'],
            'mentor' => $mentors
        ]
    );


    $errors = $form->errors();
    
    if (!empty($errors)){

        $userStudents = $db->query('SELECT 
                        students.fname AS student, 
                        GROUP_CONCAT(users.email) AS mentor,
                        students.id AS student_id
                        FROM users_students
                        JOIN students ON users_students.student_id = students.id
                        JOIN users ON users_students.user_id = users.id
                        GROUP BY student_id')->get();
        $users = $db->query('SELECT * FROM users')->get();
        view("students/index.view.php", [
            'heading' => 'Create student',
            'userStudents' => $userStudents,
            'users' => $users,
            'errors' => $errors
        ]);
    }

    if (empty($errors)) {
        $db->query('INSERT INTO students(fname) VALUES(:fname)', [
            'fname' => ucfirst(strtolower($_POST['student_name'])),
        ]);

        $student_id = $db->query('SELECT * FROM students WHERE fname = :fname', ['fname' => $_POST['student_name']])->findOrFail();

        $mentors = $_POST['mentor'];

        foreach ($mentors as $mentor) {
            $db->query('INSERT INTO users_students (user_id, student_id) VALUES(:user_id, :student_id)', [
                'user_id' => $mentor,
                'student_id' => $student_id['id'],
            ]);
        }

        header('Location: /students');
        die();
    }

}