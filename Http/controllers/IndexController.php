<?php

namespace Http\controllers;

use Core\App;
use Core\Session;
use Http\models\MeetingsModel;
use Http\models\StudentModel;

class IndexController
{
    public function index()
    {
        if (isset($_SESSION['user']) && isset($_SESSION['user']['email'])) {
            $_SESSION['name'] = $_SESSION['user']['email'];
        }
        /* @var MeetingsModel $meetingsModel */
        $meetingsModel = App::resolve(MeetingsModel::class);
        $datesQuery = $meetingsModel->dateRange();
        /* @var StudentModel $studentModel */
        $studentModel = App::resolve(StudentModel::class);

        $minDate = $datesQuery[0]['minDate'];
        $maxDate = date("Y-m-d", strtotime($datesQuery[0]['maxDate'] . ' +1 day'));


        $startDate = !empty($_GET['startDate']) ? $_GET['startDate'] : $minDate;
        $endDate = !empty($_GET['endDate']) ? $_GET['endDate'] : $maxDate;
        $uniqueUsers = [];
        $params = [];

        $uniqueStudents = $meetingsModel->uniqueStudentsFromMeetings();

        if (Session::isAdmin()) {
            $uniqueStudents = $meetingsModel->AllUniqueStudents();
            $meetings = $meetingsModel->queryForMeetings($startDate, $endDate);
            $meetingByStudent = $studentModel->queryMeetingByStudent($startDate, $endDate);
            $meetingsByMentor = $meetingsModel->queryMeetingByMentor($startDate, $endDate);
        } else {
            $meetings = $meetingsModel->queryForMeetingsNotAdmin($startDate, $endDate, $_SESSION['user']['user_id']);
            $meetingByStudent = $meetingsModel->queryMeetingByStudentNotAdmin(
                $startDate,
                $endDate,
                $_SESSION['user']['user_id'],
            );
            $meetingsByMentor = [];
        }
        view("index.view.php", [
            'heading' => 'Home',
            'meetingCount' => count($meetings),
            'meetingByStudent' => $meetingByStudent,
            'meetingsByMentor' => $meetingsByMentor,
            'uniqueUsers' => $uniqueUsers,
            'uniqueStudents' => $uniqueStudents,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }
}