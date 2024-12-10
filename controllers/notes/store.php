<?php 

use Core\Validator;
use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!Validator::string($_POST['body'], 1, 1000)) {
        $errors['body'] = 'A body of no more than 1,000 characters is required.';
    }
    
    if(!empty($errors)){
        view("notes/create.view.php", [
            'heading' => 'Create Note',
            'errors' => $errors
        ]);
    }

    if (empty($errors)) {
        $db->query('INSERT INTO posts(student_id, topic, body, user_id) VALUES(:student_id, :topic, :body, :user_id)', [
            'student_id' => $_POST['student_id'],
            'topic' => $_POST['topic'],
            'body' => $_POST['body'],
            'user_id' => 1
        ]);

        header('Location: /notes');
        die();
    }
}