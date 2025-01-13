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

    if(!empty($errors)){
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

        header('Location: /students');
        die();
    }
}