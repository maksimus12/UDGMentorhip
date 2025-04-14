<?php

use Core\Database;
use Core\App;
use Core\Validator;

$db = App::resolve(Database::class);

$student = $db->query('SELECT * FROM students WHERE id = :id', ['id' => $_POST['id']])->find();


$errors = [];

if (!Validator::string($_POST['student_name'], 1, 50)) {
    $errors['student_name'] = 'A Name of no more than 50 and no less then 1 characters is required.';
}

if (!empty($errors)) {

    view("students/edit.view.php", [
        'heading' => 'Update student',
        'student' => $student,
        'errors' => $errors
    ]);
    return;
}


$db->query('update students set fname = :fname where id = :id', [
    'fname' => $_POST['student_name'],
    'id' => $_POST['id']
]);

$db->query('DELETE FROM users_students WHERE student_id = :student_id', [
    'student_id' => $_POST['id']
]);

$selectedMentors = $_POST['mentor'] ?? $errors['mentor'] = 'Should be at least one mentor selected'; // Получаем массив выбранных менторов или пустой массив
foreach ($selectedMentors as $mentorId) {
    $db->query('INSERT INTO users_students (user_id, student_id) VALUES (:user_id, :student_id)', [
        'user_id' => $mentorId,
        'student_id' => $_POST['id']
    ]);
}

header('Location: /students');
die();