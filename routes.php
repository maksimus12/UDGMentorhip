<?php

$router->get('/', 'controllers/index.php');
$router->get('/about', 'controllers/about.php');
$router->get('/contact', 'controllers/contact.php');

$router->get('/students', 'controllers/students/index.php')->only('auth');
$router->post('/students', 'controllers/students/store.php');
$router->delete('/students', 'controllers/students/destroy.php');
$router->get('/student/edit', 'controllers/students/edit.php');
$router->patch('/student', 'controllers/students/update.php');

$router->get('/meetings', 'controllers/meetings/index.php')->only('auth');
$router->get('/meeting', 'controllers/meetings/show.php');
$router->delete('/meeting', 'controllers/meetings/destroy.php');

$router->post('/meetings', 'controllers/meetings/store.php');
$router->get('/meetings/create', 'controllers/meetings/create.php');

$router->patch('/meeting', 'controllers/meetings/update.php');
$router->get('/meeting/edit', 'controllers/meetings/edit.php');

$router->get('/students', 'controllers/students/index.php')->only('auth');

$router->get('/register', 'controllers/registration/create.php')->only('guest');
$router->post('/register', 'controllers/registration/store.php')->only('guest');

$router->get('/login', 'controllers/sessions/create.php')->only('guest');
$router->post('/sessions', 'controllers/sessions/store.php')->only('guest');
$router->delete('/sessions', 'controllers/sessions/destroy.php')->only('auth');