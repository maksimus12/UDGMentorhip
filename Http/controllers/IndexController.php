<?php

namespace Http\controllers;

use Core\App;
use Core\Session;
use Http\models\IndexModel;

class IndexController
{
    public function index()
    {
        if (isset($_SESSION['user']) && isset($_SESSION['user']['email'])) {
            $_SESSION['name'] = $_SESSION['user']['email'];
        }
        /* @var IndexModel $indexModel */
        $indexModel = App::resolve(IndexModel::class);
        $datesQuery = $indexModel->dateRange();

        $minDate = $datesQuery[0]['minDate'];
        $maxDate = date("Y-m-d", strtotime($datesQuery[0]['maxDate'] . ' +1 day'));


        $startDate = !empty($_GET['startDate']) ? $_GET['startDate'] : $minDate;
        $endDate = !empty($_GET['endDate']) ? $_GET['endDate'] : $maxDate;
        $uniqueUsers = [];
        $params = [];

        $uniqueStudents = $indexModel->uniqueStudentsFromMeetings();

        if (Session::isAdmin()) {
            $uniqueStudents = $indexModel->AllUniqueStudents();
            $meetings = $indexModel->queryForMeetings($startDate, $endDate);
            $meetingByStudent = $indexModel->queryMeetingByStudent($startDate, $endDate);
            $meetingsByMentor = $indexModel->queryMeetingByMentor($startDate, $endDate);
        } else {
            $meetings = $indexModel->queryForMeetingsNotAdmin($startDate, $endDate, $_SESSION['user']['user_id']);
            $meetingByStudent = $indexModel->queryMeetingByStudentNotAdmin(
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