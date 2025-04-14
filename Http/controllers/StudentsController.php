<?php

namespace Http\controllers;

use Core\App;
use Http\Models\StudentModel;
use Http\Models\UserModel;

class StudentsController
{
    public function index(): void
    {
        /** @var UserModel $usersModel */
        $usersModel = App::resolve(UserModel::class);
        $users = $usersModel->getAll();

        /** @var StudentModel $studentModel */
        $studentModel = App::resolve(StudentModel::class);
        $userStudents = $studentModel->getStudentsWithMenthors();

        view("students/index.view.php", [
            'heading' => 'Students',
            'users' => $users,
            'userStudents' => $userStudents,
        ]);
    }
}
