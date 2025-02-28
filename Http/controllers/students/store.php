<?php

use Core\Validator;
use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (!Validator::string($_POST['student_name'], 1, 50)) {
        $errors['student_name'] = 'A Name should be no more than 50 characters is required.';
    }

    if (!empty($errors)) {
        $students = $db->query('SELECT * FROM students')->get();
        view("students/index.view.php", [
            'heading' => 'Create student',
            'students' => $students,
            'errors' => $errors
        ]);
    }

    if (empty($errors)) {
        $db->query('INSERT INTO students(fname) VALUES(:fname)', [
            'fname' => ucfirst(strtolower($_POST['student_name'])),
        ]);

        $student_id = $db->query('SELECT * FROM students WHERE fname = :fname', ['fname' => $_POST['student_name']])->findOrFail();

        $mentors = $_POST;

        foreach ($mentors['mentor'] as $mentor) {
            $db->query('INSERT INTO users_students (user_id, student_id) VALUES(:user_id, :student_id)', [
                'user_id' => $mentor,
                'student_id' => $student_id['id'],
            ]);
        }



        header('Location: /students');
        die();
    }
}