<?php

namespace Http\models;

use Core\BasicModel;

class IndexModel extends BasicModel
{

    public function dateRange()
    {
        return $this->db->query(
            "SELECT MIN(meeting_datetime) AS minDate, MAX(meeting_datetime) AS maxDate FROM meetings",
        )->get();
    }

    public function uniqueStudentsFromMeetings()
    {
        return $this->db->query(
            'SELECT DISTINCT
        students.id,
         students.fname
         FROM meetings
        INNER JOIN students ON meetings.student_id = students.id',
        )->get();
    }

    public function AllUniqueStudents()
    {
        return $this->db->query(
            'SELECT DISTINCT
        users.id,
        users.email
         FROM meetings
         INNER JOIN users ON meetings.user_id = users.id
         WHERE users.is_deleted = 0',
        )->get();
    }

    public function queryForMeetings($startDate, $endDate)
    {
        return $this->db->query(
            'SELECT *
                FROM meetings 
                INNER JOIN users ON meetings.user_id = users.id
                WHERE users.is_deleted = 0 AND meetings.meeting_datetime BETWEEN :start AND :end',
            [
                'start' => $startDate,
                'end' => $endDate,
            ],
        )->get();
    }

    public function queryMeetingByStudent($startDate, $endDate)
    {
        return $this->db->query(
            'SELECT 
                students.fname AS studentName, 
                count(meetings.id) AS meetingCount 
                FROM students 
                LEFT JOIN meetings 
                ON students.id = meetings.student_id 
                WHERE meetings.meeting_datetime BETWEEN :start AND :end
                GROUP BY students.id, students.fname 
                ORDER BY meetingCount DESC',
            [
                'start' => $startDate,
                'end' => $endDate,
            ],
        )->get();
    }

    public function queryMeetingByMentor($startDate, $endDate)
    {
        return $this->db->query(
            'SELECT 
                users.email AS username, 
                count(meetings.id) AS meetingCount 
                FROM users 
                LEFT JOIN meetings 
                ON users.id = meetings.user_id 
                WHERE meetings.meeting_datetime BETWEEN :start AND :end
                GROUP BY users.id, users.email 
                ORDER BY meetingCount DESC',
            [
                'start' => $startDate,
                'end' => $endDate,
            ],
        )->get();
    }

    public function queryForMeetingsNotAdmin($startDate, $endDate, $userId)
    {
        return $this->db->query(
            'SELECT * FROM meetings 
            INNER JOIN users ON meetings.user_id = users.id
            WHERE users.is_deleted = 0 
            AND meetings.meeting_datetime 
            BETWEEN :start AND :end AND meetings.user_id = :id',
            [
                'start' => $startDate,
                'end' => $endDate,
                'id' => $userId,
            ],
        )->get();
    }

    public function queryMeetingByStudentNotAdmin($startDate, $endDate, $userId)
    {
        return $this->db->query(
            'SELECT 
                students.fname AS studentName, 
                count(meetings.id) AS meetingCount 
                FROM students 
                LEFT JOIN meetings 
                ON students.id = meetings.student_id 
                WHERE meetings.meeting_datetime BETWEEN :start AND :end AND meetings.user_id = :id
                GROUP BY students.id, students.fname 
                ORDER BY meetingCount DESC',
            [
                'start' => $startDate,
                'end' => $endDate,
                'id' => $userId,
            ],
        )->get();
    }
}