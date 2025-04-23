<?php

namespace Http\controllers;

use Core\App;
use Core\Session;
use Core\UserRoles;
use Http\Forms\EditMentorForm;
use Http\Forms\EditMentorPassForm;
use Http\Forms\RegistrationForm;
use Http\models\UserModel;

class MentorsController
{
    /* @var UserModel $userModel */
    protected $userModel;

    public function __construct()
    {
        $this->userModel = App::resolve(UserModel::class);
    }

    public function index()
    {
        $mentors = $this->userModel->getAll();
        view("mentors/index.view.php", [
            'heading' => 'Mentors',
            'mentors' => $mentors,
            'errors' => Session::get('errors', []),
        ]);
    }

    public function create()
    {
        $email = $_POST['mentor_email'];
        $password = $_POST['password'];
        $user = $this->userModel->findUserByEmail($_POST['mentor_email']);

        $attributes = [
            'email' => $email,
            'password' => $password,
            'user' => $user,
        ];
        RegistrationForm::make($attributes);
        $this->userModel->createNewUser($email, $password, UserRoles::USER);
        header('Location: /mentors');
        die();
    }

    public function delete()
    {
        $this->userModel->deleteUser($_POST['id']);
        header('Location: /mentors');
        exit();
    }

    public function edit()
    {
        $mentor = $this->userModel->findUserById($_GET['id']);
        view("mentors/edit.view.php", [
            'heading' => 'Mentors',
            'mentor' => $mentor,
            'errors' => Session::get('errors', []),
        ]);
    }

    public function editpass()
    {
        $mentor = $this->userModel->findUserById($_GET['id']);
        view("mentors/editpass.view.php", [
            'heading' => 'Mentors',
            'mentor' => $mentor,
        ]);
    }

    public function update()
    {
        $attributes = [
            'email' => $_POST['email'],
        ];

        EditMentorForm::make($attributes);
        $this->userModel->updateUserInfo($_POST['email'], $_POST['role'], $_POST['status'], $_POST['id']);
        header('Location: /mentors');
        die();
    }

    public function updatepass()
    {
        $attributes = [
            'pass' => $_POST['new-pass'],
        ];
        EditMentorPassForm::make($attributes);
        $this->userModel->updateUserPassword($_POST['new-pass'], $_POST['id']);
        header('Location: /mentors');
        die();
    }
}