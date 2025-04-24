<?php

namespace Http\controllers;

use Core\App;
use Core\Session;
use Http\Forms\MeetingCreateForm;
use Http\models\MeetingsModel;
use Http\models\StudentModel;

class MeetingsController
{
    /* @var MeetingsModel $meetingsModel */
    protected $meetingsModel;

    /* @var StudentModel $studentModel */
    protected $studentModel;

    public function __construct()
    {
        $this->meetingsModel = App::resolve(MeetingsModel::class);
        $this->studentModel = App::resolve(StudentModel::class);
    }

    public function index()
    {
        authorize(isset($_SESSION['user']));


        $datesQuery = $this->meetingsModel->dateRange();
        /* @var StudentModel $studentModel */


        $minDate = $datesQuery[0]['minDate'];
        $maxDate = date("Y-m-d", strtotime($datesQuery[0]['maxDate'] . ' +1 day'));

        $startDate = $_GET['startDate'] ?? $minDate;
        $endDate = $_GET['endDate'] ?? $maxDate;


        $filters = [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'mentor' => !empty($_GET['mentor']) ? $_GET['mentor'] : null,
            'student' => !empty($_GET['student']) ? $_GET['student'] : null,
        ];

        $firstRecord = 0;
        $rows_per_page = (int)25;

        if (isset($_GET['page-nr']))
        {
            $page = $_GET['page-nr']-1;
            $firstRecord = $page * $rows_per_page;
        }


        if (Session::isAdmin()) {
            $uniqueStudents = $this->meetingsModel->uniqueStudentsFromMeetings();
            $meetings = $this->meetingsModel->getMeetingsForAdmin($firstRecord,$rows_per_page,$filters);
            $uniqueUsers = $this->meetingsModel->AllUniqueUsers();
            $allRecords = $this->meetingsModel->getNumberOfAllMeetingsForAdmin();
            $pages = $this->meetingsModel->getNumberOfAllMeetingsPagesForAdmin($rows_per_page);

        } else {
            $uniqueStudents = $this->studentModel->uniqueStudentsByMentor($_SESSION['user']['user_id']);
            $meetings = $this->meetingsModel->getMeetingsForUser($_SESSION['user']['user_id'], $filters);
            $uniqueUsers = [];
        }
        view("meetings/index.view.php", [
            'heading' => 'My meetings',
            'meetings' => $meetings,
            'uniqueUsers' => $uniqueUsers,
            'uniqueStudents' => $uniqueStudents,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'allRecords' => $allRecords,
            'pages' => $pages,
        ]);
    }

    public function show()
    {
        $meeting = $this->meetingsModel->getMeetingById($_GET['id']);
        authorize($meeting['user_id'] === \Core\Session::getUserId() || \Core\Session::isAdmin());

        view("meetings/show.view.php", [
            'heading' => 'Meeting',
            'meeting' => $meeting,
        ]);
    }

    public function destroy()
    {
        $meeting = $this->meetingsModel->getMeetingById($_POST['id']);
        authorize($meeting['user_id'] === \Core\Session::getUserId() || \Core\Session::isAdmin());
        $this->meetingsModel->deleteMeeting($_POST['id']);
        header('Location: /meetings');
        exit;
    }

    public function create()
    {
        if (Session::isAdmin()) {
            $students = $this->studentModel->getAllStudents();
        } else {
            $students = $this->studentModel->uniqueStudentsByMentor($_SESSION['user']['user_id']);
        }

        view("meetings/create.view.php", [
            'students' => $students,
            'heading' => 'Create meeting',
            'errors' => Session::get('errors'),
        ]);
    }

    public function store()
    {
        MeetingCreateForm::make(
            $attributes = [
                'date' => $_POST['meeting_datetime'],
                'body' => $_POST['body'],
                'topic' => $_POST['topic'],
            ],
        );
        $this->meetingsModel->createNewMeeting(
            $_POST['student_id'],
            $_POST['topic'],
            $_POST['body'],
            $_SESSION['user']['user_id'],
            $_POST['meeting_datetime'],
        );
        header('Location: /meetings');
        exit;
    }

    public function edit()
    {
        if (Session::isAdmin()) {
            $students = $this->studentModel->getAllStudents();
        } else {
            $students = $this->studentModel->uniqueStudentsByMentor($_SESSION['user']['user_id']);
        }
        $meeting = $this->meetingsModel->getMeetingById($_GET['id']);
        view("meetings/edit.view.php", [
            'heading' => 'Edit meeting',
            'meeting' => $meeting,
            'students' => $students,
        ]);
    }

    public function update()
    {
        $meeting = $this->meetingsModel->getMeetingById($_POST['id']);
        authorize($meeting['user_id'] === Session::getUserId() || Session::isAdmin());
        MeetingCreateForm::make(
            $attributes = [
                'date' => $_POST['meeting_datetime'],
                'body' => $_POST['body'],
                'topic' => $_POST['topic'],
            ],
        );
        $attributes = [
            'id' => $_POST['id'],
            'body' => $_POST['body'],
            'student_id' => $_POST['student_id'],
            'topic' => $_POST['topic'],
            'meeting_datetime' => $_POST['meeting_datetime'],
        ];
        $this->meetingsModel->updateMeeting($attributes);
        header('Location: /meetings');
        exit;
    }
}