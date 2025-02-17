<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$db->query('update users set is_deleted = 1 where id = :id', [
    'id' => $_POST['id']
]);

header('Location: /mentors');
exit();