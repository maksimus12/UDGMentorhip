<?php

namespace Http\controllers;

use Core\App;
use Core\Database;
use Core\ValidationException;
use Core\Session;
use Http\Forms\AddStudentForm;
use Http\Forms\EditStudentForm;
use Http\models\StudentModel;
use Http\models\UserModel;

class StudentsController
{

    /* @var UserModel $userModel */
    protected $userModel;

    /* @var StudentModel $studentModel */
    protected $studentModel;

    public function __construct()
    {
        $this->userModel = App::resolve(UserModel::class);
        $this->studentModel = App::resolve(StudentModel::class);
    }


    public function index()
    {
        $users = $this->userModel->getAll();
        $userStudents = $this->studentModel->getStudentsWithMentors();
        $errors = Session::get('errors', []);
        $old = Session::get('old', []);

        view("students/index.view.php", [
            'heading' => 'Students',
            'users' => $users,
            'userStudents' => $userStudents,
            'errors' => $errors,
            'old' => $old,
        ]);
    }


    public function create()
    {
        $student = $_POST['student_name'];
        $mentor = $_POST['mentor'];
        $attributes = [
            'student_name' => $student,
            'mentor' => $mentor ?? null,
        ];

        AddStudentForm::make($attributes);

        /* @var StudentModel $studentModel */
        $this->studentModel->insertStudent($student);
        $studentID = $this->studentModel->getStudent($student);
        $this->studentModel->insertMixStudentMentor($mentor, $studentID['id']);
        header('Location: /students');
        die();
    }


    public function delete()
    {
        $this->studentModel->delete($_POST['id']);
        header('Location: /students');
        die();
    }


    public function edit()
    {
        $allUsers = $this->userModel->getAll();
        $userStudent = $this->studentModel->getStudentNameAndId($_GET['id']);
        $mentors = $this->userModel->getMentorNameAndId($_GET['id']);
        $mentorIds = array_column($mentors, 'user_id');
        $errors = Session::get('errors', []);
        $old = Session::get('old', []);

        view("students/edit.view.php", [
            'heading' => 'Students',
            'allUsers' => $allUsers,
            'userStudent' => $userStudent,
            'mentors' => $mentors,
            'mentorIds' => $mentorIds,
            'errors' => $errors,
            'old' => $old,
        ]);
    }

    public function update()
    {
        $this->studentModel->getStudentById($_POST['id']);
        EditStudentForm::make($_POST);
        $this->studentModel->updateStudent($_POST);
        $this->studentModel->deleteStudentWithMentors($_POST['id']);
        $selectedMentors = $_POST['mentor'] ?? $errors['mentor'] = 'Should be at least one mentor selected';
        $this->studentModel->updateMentors($selectedMentors);
        header('Location: /students');
        die();
    }
}