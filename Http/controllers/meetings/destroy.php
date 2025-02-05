<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$currentUserId = $_SESSION['user']['user_id'];


$meeting = $db->query('select * from meetings where id = :id', [
    'id' => $_POST['id'],
])->findOrFail();


if ($_SESSION['user']['user_role'] !== \Core\UserRoles::ADMIN) {
    authorize($meeting['user_id'] === $currentUserId);
}


$db->query('delete from meetings where id = :id', [
    'id' => $_POST['id'],
]);

header('Location: /meetings');
exit();



