<?php



if (isset($_SESSION['user']) && isset($_SESSION['user']['email'])) {
    $_SESSION['name'] = $_SESSION['user']['email'];
}



view("index.view.php", [
    'heading' => 'Home',
]);