<?php

$_SESSION['name'] =  $_SESSION['user']['email'];

view("index.view.php", [
    'heading' => 'Home',
]);