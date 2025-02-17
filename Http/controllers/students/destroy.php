<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$db->query('delete from students where id = :id', [
    'id' => $_POST['id']
]);

header('Location: /students');
exit();