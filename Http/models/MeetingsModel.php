<?php

namespace Http\models;

use Core\BasicModel;

class MeetingsModel extends BasicModel
{

    public function getMeetingById($id)
    {
        return $this->db->query(
            'SELECT 
            meetings.id as post_id,
            meetings.created_at as created_at,
            meetings.meeting_datetime as meeting_datetime,
            students.id as student_id,
            users.id as user_id,
            users.email as email,
            students.fname,
            meetings.topic,
            meetings.body
            FROM meetings
            INNER JOIN users ON meetings.user_id = users.id
            INNER JOIN students ON meetings.student_id = students.id
            where meetings.id = :id',
            [
                'id' => $id,
            ],
        )->findOrFail();
    }

    public function deleteMeeting($id)
    {
        $this->db->query('delete from meetings where id = :id', [
            'id' => $id,
        ]);
    }

    public function createNewMeeting($studentId, $topic, $body, $createdBy, $createdDate)
    {
        $this->db->query(
            'INSERT INTO meetings(student_id, topic, body, user_id, meeting_datetime) VALUES(:student_id, :topic, :body, :user_id, :meeting_datetime)',
            [
                'student_id' => $studentId,
                'topic' => $topic,
                'body' => $body,
                'user_id' => $createdBy,
                'meeting_datetime' => $createdDate,
            ],
        );
    }

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

    public function AllUniqueUsers()
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

    public function getMeetingsForAdmin(array $filters)
    {
        $sql = 'SELECT
                meetings.id,
                meetings.meeting_datetime,
                meetings.user_id,
                students.fname,
                users.email,
                meetings.topic
                FROM meetings
                INNER JOIN users ON meetings.user_id = users.id
                INNER JOIN students ON meetings.student_id = students.id
                WHERE users.is_deleted = 0 AND meeting_datetime BETWEEN :start AND :end';

        $params = [
            'start' => $filters['startDate'],
            'end' => $filters['endDate'],
        ];

        if (!empty($filters['mentor'])) {
            $sql .= ' AND meetings.user_id = :user_id';
            $params['user_id'] = $filters['mentor'];
        }

        if (!empty($filters['student'])) {
            $sql .= ' AND meetings.student_id = :student_id';
            $params['student_id'] = $filters['student'];
        }

        return $this->db->query($sql, $params)->get();
    }

    public function getMeetingsForUser($userId, array $filters)
    {
        $sql = 'SELECT
                meetings.id,
                meetings.meeting_datetime,
                meetings.user_id,
                students.fname,
                meetings.topic
                FROM meetings
                INNER JOIN users ON meetings.user_id = users.id
                INNER JOIN students ON meetings.student_id = students.id
                where meetings.user_id = :user_id AND meeting_datetime BETWEEN :start AND :end';

        $params = [
            'user_id' => $userId,
            'start' => $filters['startDate'],
            'end' => $filters['endDate'],
        ];

        if (!empty($filters['student'])) {
            $sql .= ' AND meetings.student_id = :student_id';
            $params['student_id'] = $filters['student'];
        }

        return $this->db->query($sql, $params)->get();
    }

    public function updateMeeting($attributes)
    {
        $this->db->query(
            'update meetings set body = :body, student_id = :student_id, topic = :topic, meeting_datetime = :meeting_datetime  where id = :id',
            [
                'id' => $attributes['id'],
                'body' => $attributes['body'],
                'student_id' => $attributes['student_id'],
                'topic' => $attributes['topic'],
                'meeting_datetime' => $attributes['meeting_datetime'],
            ],
        );
    }
}