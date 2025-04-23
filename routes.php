<?php
//Define var for IDE hinting
/** @var $router */

use Http\controllers\StudentsController;
use Http\controllers\IndexController;

//$router->get('/', '/index.php')->only('auth');
//$router->get('/about', '/about.php');
//$router->get('/contact', '/contact.php');

$router->get('/', IndexController::class, 'index')->only('auth');
$router->get('/students', StudentsController::class, 'index')->only('admin');
$router->post('/students', StudentsController::class, 'create')->only('admin');
$router->delete('/students', StudentsController::class, 'delete')->only('admin');
$router->get('/student/edit', StudentsController::class, 'edit')->only('admin');
$router->patch('/student', StudentsController::class, 'update')->only('admin');

$router->get('/meetings', '/meetings/index.php')->only('auth');
$router->get('/meeting', '/meetings/show.php');
$router->delete('/meeting', '/meetings/destroy.php');

$router->post('/meetings', '/meetings/store.php');
$router->get('/meetings/create', '/meetings/create.php');

$router->patch('/meeting', '/meetings/update.php');
$router->get('/meeting/edit', '/meetings/edit.php');

$router->get('/mentors', '/mentors/index.php')->only('admin');
$router->post('/mentors', '/mentors/store.php')->only('admin');
$router->get('/mentor/edit', '/mentors/edit.php')->only('admin');
$router->get('/mentor/editpass', '/mentors/editpass.php')->only('admin');
$router->patch('/mentor', '/mentors/update.php')->only('admin');
$router->patch('/mentorpass', '/mentors/updatepass.php')->only('admin');
$router->delete('/mentors', '/mentors/destroy.php')->only('admin');

$router->get('/register', '/registration/create.php')->only('guest');
$router->post('/register', '/registration/store.php')->only('guest');

$router->get('/login', '/sessions/create.php')->only('guest');
$router->post('/sessions', '/sessions/store.php')->only('guest');
$router->delete('/sessions', '/sessions/destroy.php')->only('auth');
