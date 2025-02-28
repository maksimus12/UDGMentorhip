<?php

use Core\Database;
use Core\App;

if (isset($_SESSION['user']) && isset($_SESSION['user']['email'])) {
    $_SESSION['name'] = $_SESSION['user']['email'];
}
$db = App::resolve(Database::class);

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
         WHERE users.is_deleted = 0')->get();

    $queryForMeetings = 'SELECT * FROM meetings 
                        INNER JOIN users ON meetings.user_id = users.id
                        WHERE users.is_deleted = 0 AND meetings.meeting_datetime BETWEEN :start AND :end';

    $queryMeetingByStudent = 'SELECT 
                students.fname AS studentName, 
                count(meetings.id) AS meetingCount 
                FROM students 
                LEFT JOIN meetings 
                ON students.id = meetings.student_id 
                WHERE meetings.meeting_datetime BETWEEN :start AND :end
                GROUP BY students.id, students.fname 
                ORDER BY meetingCount DESC';

    $queryMeetingByMentor = 'SELECT 
                users.email AS username, 
                count(meetings.id) AS meetingCount 
                FROM users 
                LEFT JOIN meetings 
                ON users.id = meetings.user_id 
                WHERE meetings.meeting_datetime BETWEEN :start AND :end
                GROUP BY users.id, users.email 
                ORDER BY meetingCount DESC';

    $params = [ 'start' => $startDate, 'end' => $endDate];

    $meetings = $db->query($queryForMeetings, $params)->get();
    $meetingByStudent = $db->query($queryMeetingByStudent, $params)->get();
    $meetingsByMentor = $db->query($queryMeetingByMentor, $params)->get();

}else{
    $queryForMeetings = 'SELECT * FROM meetings 
                        INNER JOIN users ON meetings.user_id = users.id
                        WHERE users.is_deleted = 0 AND meetings.meeting_datetime BETWEEN :start AND :end AND meetings.user_id = :id';

    $queryMeetingByStudent = 'SELECT 
                students.fname AS studentName, 
                count(meetings.id) AS meetingCount 
                FROM students 
                LEFT JOIN meetings 
                ON students.id = meetings.student_id 
                WHERE meetings.meeting_datetime BETWEEN :start AND :end AND meetings.user_id = :id
                GROUP BY students.id, students.fname 
                ORDER BY meetingCount DESC';

    $params = [ 'start' => $startDate,
                'end' => $endDate,
                'id' => $_SESSION['user']['user_id'],];

    $meetings = $db->query($queryForMeetings, $params)->get();
    $meetingByStudent = $db->query($queryMeetingByStudent, $params)->get();
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