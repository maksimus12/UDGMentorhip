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
        view("meetings/create.view.php", [
            'heading' => 'Create meeting',
            'errors' => $errors
        ]);
    }

    if (empty($errors)) {
        $db->query('INSERT INTO meetings(student_id, topic, body, user_id, meeting_datetime) VALUES(:student_id, :topic, :body, :user_id, :meeting_datetime)', [
            'student_id' => $_POST['student_id'],
            'topic' => $_POST['topic'],
            'body' => $_POST['body'],
            'user_id' => $_SESSION['user']['user_id'],
            'meeting_datetime' => $_POST['meeting_datetime']
        ]);

        header('Location: /meetings');
        die();
    }
}