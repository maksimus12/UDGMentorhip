<?php

use Core\Database;
use Core\App;

$db = App::resolve(Database::class);

authorize(isset($_SESSION['user']));

$datesQuery = $db->query("SELECT MIN(meeting_datetime) AS minDate, MAX(meeting_datetime) AS maxDate FROM meetings")->get();

$minDate = $datesQuery[0]['minDate'];
$maxDate = $datesQuery[0]['maxDate'];

$startDate = $_GET['startDate'] ?? $minDate;
$endDate = $_GET['endDate'] ?? $maxDate;
$uniqueUsers = [];

if (Core\Session::isAdmin()) {
    $uniqueUsers = $db->query(
        'SELECT DISTINCT
        users.id,
            sers.email
         FROM meetings
         INNER JOIN users ON meetings.user_id = users.id
         WHERE users.is_deleted = 0'
    )->get();


    $meetings = null;

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

        $params = [];

        if(!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
            $query .= ' AND meetings.meeting_datetime BETWEEN :start AND :end';
            $params =
                [
                    'start' => $_GET['start_date'],
                    'end' => $_GET['end_date']
                ];
        }

         if(!empty($_GET['mentor'])){
             $query .= ' AND meetings.user_id = :user_id';
             $params['user_id'] = $_GET['mentor'];
         }

        $meetings = $db->query($query, $params)->get();

} else {
    $meetings = $db->query(
        'SELECT 
                meetings.id,   
                meetings.meeting_datetime,
                meetings.user_id,
                students.fname,
                meetings.topic
                FROM meetings
                INNER JOIN users ON meetings.user_id = users.id
                INNER JOIN students ON meetings.student_id = students.id 
                where meetings.user_id = :user_id AND meetings.meeting_datetime BETWEEN :start AND :end',
        [
            'user_id' => Core\Session::getUserId(),
            'start' => $startDate,
            'end' => $endDate
        ],
    )->get();
}

view("meetings/index.view.php", [
    'heading' => 'My meetings',
    'meetings' => $meetings,
    'uniqueUsers' => $uniqueUsers,
    'startDate' => $startDate,
    'endDate' => $endDate,
]);