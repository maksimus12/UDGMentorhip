<?php

use Core\Database;
use Core\App;
use Core\Validator;

$db = App::resolve(Database::class);


$currentUserId = $_SESSION['user']['user_id'];

$meeting = $db->query('select * from meetings where id = :id', [
    'id' => $_POST['id'],
])->findOrFail();

if (!$_SESSION['user']['user_role'] == \Core\UserRoles::ADMIN) {
    authorize($meeting['user_id'] === $currentUserId);
}

$errors = [];

if (!Validator::string($_POST['body'], 1, 1000)) {
    $errors['body'] = 'A body of no more than 1,000 characters is required.';
}


if (count($errors)) {
    return view('meetings/edit.view.php', [
        'heading' => 'Edit meeting',
        'errors' => $errors,
        'meeting' => $meeting,
    ]);
}

$db->query(
    'update meetings set body = :body, student_id = :student_id, topic = :topic, meeting_datetime = :meeting_datetime  where id = :id',
    [
        'id' => $_POST['id'],
        'body' => $_POST['body'],
        'student_id' => $_POST['student_id'],
        'topic' => $_POST['topic'],
        'meeting_datetime' => $_POST['meeting_datetime'],
    ],
);

header('Location: /meetings');
die();