<?php
//Define var for IDE hinting

/** @var $router */

use Http\controllers\LoginController;
use Http\controllers\MentorsController;
use Http\controllers\StudentsController;
use Http\controllers\IndexController;
use Http\controllers\RegistrationController;

$router->get('/about', '/about.php');
$router->get('/contact', '/contact.php');

$router->get('/', IndexController::class, 'index')->only('auth');
$router->get('/students', StudentsController::class, 'index')->only('admin');
$router->post('/students', StudentsController::class, 'create')->only('admin');
$router->delete('/students', StudentsController::class, 'delete')->only('admin');
$router->get('/student/edit', StudentsController::class, 'edit')->only('admin');
$router->patch('/student', StudentsController::class, 'update')->only('admin');

$router->get('/meeting', '/meetings/show.php');
$router->delete('/meeting', '/meetings/destroy.php');
$router->post('/meetings', '/meetings/store.php');
$router->get('/meetings/create', '/meetings/create.php');
$router->patch('/meeting', '/meetings/update.php');
$router->get('/meeting/edit', '/meetings/edit.php');

$router->get('/mentors', MentorsController::class, 'index')->only('admin');
$router->post('/mentors', MentorsController::class, 'create')->only('admin');
$router->delete('/mentors', MentorsController::class, 'delete')->only('admin');
$router->get('/mentor/edit', MentorsController::class, 'edit')->only('admin');
$router->get('/mentor/editpass', MentorsController::class, 'editpass')->only('admin');
$router->patch('/mentor', MentorsController::class, 'update')->only('admin');
$router->patch('/mentorpass', MentorsController::class, 'updatepass')->only('admin');

$router->get('/register', RegistrationController::class, 'index')->only('guest');
$router->post('/register', RegistrationController::class, 'register')->only('guest');

$router->get('/login', LoginController::class, 'index')->only('guest');
$router->post('/sessions', LoginController::class, 'login')->only('guest');
$router->delete('/sessions', LoginController::class, 'logout')->only('auth');
