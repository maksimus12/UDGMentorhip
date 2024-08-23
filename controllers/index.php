<?php

$_SESSION['name'] = 'Max';

view("index.view.php", [
    'heading' => 'Home',
]);