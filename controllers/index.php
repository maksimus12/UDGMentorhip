<?php

$_SESSION['name'] = 'Mark';

view("index.view.php", [
    'heading' => 'Home',
]);