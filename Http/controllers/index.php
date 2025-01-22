<?php

use Core\Database;
use Core\App;

if (isset($_SESSION['user']) && isset($_SESSION['user']['email'])) {
    $_SESSION['name'] = $_SESSION['user']['email'];
}


$db = App::resolve(Database::class);

//if(isset($_SESSION['user']['user_role']) && $_SESSION['user']['user_role'] === \Core\UserRoles::ADMIN){
//    $meetings = $db->query('SELECT * FROM meetings)->get();
//}

if (isset($_SESSION['user'])) {
    $meetings = $db->query('SELECT * FROM meetings where user_id = :user_id', [
        'user_id' => $_SESSION['user']['user_id'],
    ])->get();
} else {
    $meetings = [];
}


view("index.view.php", [
    'heading' => 'Home',
    'meetingCount' => count($meetings),
]);