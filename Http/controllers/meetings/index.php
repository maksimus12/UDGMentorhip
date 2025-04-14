<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

authorize(isset($_SESSION['user']));

$datesQuery = $db->query("SELECT MIN(meeting_datetime) AS minDate, MAX(meeting_datetime) AS maxDate FROM meetings")->get();

$minDate = $datesQuery[0]['minDate'];
$maxDate = date("Y-m-d", strtotime($datesQuery[0]['maxDate'] . ' +1 day'));

$startDate = !empty($_GET['startDate']) ? $_GET['startDate'] : $minDate;
$endDate = !empty($_GET['endDate']) ? $_GET['endDate'] : $maxDate;
$uniqueUsers = [];
$params = [];

$uniqueStudents = $db->query(
    'SELECT DISTINCT
        students.id,
         students.fname
         FROM meetings
        INNER JOIN students ON meetings.student_id = students.id'
)->get();



if (Core\Session::isAdmin()) {
    $uniqueUsers = $db->query(
        'SELECT DISTINCT
        users.id,
        users.email
         FROM meetings
         INNER JOIN users ON meetings.user_id = users.id
         WHERE users.is_deleted = 0'
    )->get();

    $meetings = [];

         $query = 'SELECT
                meetings.id,
                meetings.meeting_datetime,
                meetings.user_id,
                students.fname,
                users.email,
                meetings.topic
                FROM meetings
                INNER JOIN users ON meetings.user_id = users.id
                INNER JOIN students ON meetings.student_id = students.id
                WHERE users.is_deleted = 0';


        if(!empty($_GET['startDate']) || !empty($_GET['endDate'])) {
            $query .= ' AND meetings.meeting_datetime BETWEEN :start AND :end';
            $params =
                [
                    'start' => $startDate,
                    'end' => $endDate
                ];
        }



    if(!empty($_GET['mentor'])){
        $query .= ' AND meetings.user_id = :user_id';
        $params['user_id'] = $_GET['mentor'];
    }

    if(!empty($_GET['student'])){
        $query .= ' AND meetings.student_id = :student_id';
        $params['student_id'] = $_GET['student'];
    }

        $meetings = $db->query($query, $params)->get();


} else {

    $query = 'SELECT 
                meetings.id,   
                meetings.meeting_datetime,
                meetings.user_id,
                students.fname,
                meetings.topic
                FROM meetings
                INNER JOIN users ON meetings.user_id = users.id
                INNER JOIN students ON meetings.student_id = students.id 
                where meetings.user_id = :user_id';

    $params = ['user_id' => $_SESSION['user']['user_id']];


    if(!empty($_GET['startDate']) || !empty($_GET['endDate'])) {
        $query .= ' AND meetings.meeting_datetime BETWEEN :start AND :end';
        $params['start'] = $startDate;
        $params['end'] = $endDate;
    }



    if(!empty($_GET['student'])){
        $query .= ' AND meetings.student_id = :student_id';
        $params['student_id'] = $_GET['student'];
    }

    $meetings = $db->query($query, $params)->get();


}

view("meetings/index.view.php", [
    'heading' => 'My meetings',
    'meetings' => $meetings,
    'uniqueUsers' => $uniqueUsers,
    'uniqueStudents' => $uniqueStudents,
    'startDate' => $startDate,
    'endDate' => $endDate,
]);