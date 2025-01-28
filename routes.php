<?php

$router->get('/', '/index.php')->only('auth');
$router->get('/about', '/about.php');
$router->get('/contact', '/contact.php');

$router->get('/students', '/students/index.php')->only('auth');
$router->post('/students', '/students/store.php');
$router->delete('/students', '/students/destroy.php');
$router->get('/student/edit', '/students/edit.php');
$router->patch('/student', '/students/update.php');

$router->get('/meetings', '/meetings/index.php')->only('auth');
$router->get('/meeting', '/meetings/show.php');
$router->delete('/meeting', '/meetings/destroy.php');

$router->post('/meetings', '/meetings/store.php');
$router->get('/meetings/create', '/meetings/create.php');

$router->patch('/meeting', '/meetings/update.php');
$router->get('/meeting/edit', '/meetings/edit.php');

$router->get('/students', '/students/index.php')->only('auth');

$router->get('/register', '/registration/create.php')->only('guest');
$router->post('/register', '/registration/store.php')->only('guest');

$router->get('/login', '/sessions/create.php')->only('guest');
$router->post('/sessions', '/sessions/store.php')->only('guest');
$router->delete('/sessions', '/sessions/destroy.php')->only('auth');