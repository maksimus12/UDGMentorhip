<?php

use Core\Database;
use Core\App;
use Core\Validator;

$db = App::resolve(Database::class);


$currentUserId = $_SESSION['user']['user_id'];
$currentDateTime = date('Y-m-d H:i:s');

    $meeting = $db->query('select * from meetings where id = :id', [
        'id' => $_POST['id']
    ])->findOrFail();

authorize($meeting['user_id'] === $currentUserId);

$errors = [];

if (!Validator::string($_POST['body'], 1, 1000)) {
    $errors['body'] = 'A body of no more than 1,000 characters is required.';
}


if(count($errors)){
    return view('meetings/edit.view.php', [
        'heading' => 'Edit meeting',
        'errors' => $errors,
        'meeting' => $meeting
    ]);
}

$db->query('update meetings set body = :body, student_id = :student_id, topic = :topic, updated_at = :updated_at, meeting_datetime = :meeting_datetime  where id = :id', [
    'id' => $_POST['id'],
    'body' => $_POST['body'],
    'student_id' => $_POST['student_id'],
    'topic' => $_POST['topic'],
    'updated_at' => $currentDateTime,
    'meeting_datetime' => $_POST['meeting_datetime']
]);

header('Location: /meetings');
die();