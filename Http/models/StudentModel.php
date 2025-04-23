<?php

namespace Http\models;

use Core\BasicModel;

class StudentModel extends BasicModel
{

    public function getAllStudents()
    {
        return $this->db->query('SELECT * FROM students')->get();
    }

    public function getStudentById(int $id)
    {
        return $this->db->query("SELECT * from students where id = :id", [
            ":id" => $id,
        ])->findOrFail();
    }

    public function getStudent($student)
    {
        return $this->db->query('SELECT * FROM students WHERE fname = :fname', [
            'fname' => $student,
        ])->findOrFail();
    }

    public function getStudentsWithMentors()
    {
        return $this->db->query(
            "
            SELECT
            students.fname AS student, 
            COALESCE(GROUP_CONCAT(users.email), 'No mentor') AS mentor,
            students.id AS student_id
            FROM students
            LEFT JOIN users_students ON students.id = users_students.student_id
            LEFT JOIN users ON users_students.user_id = users.id
            GROUP BY students.id
        ",
        )->get();
    }

    public function uniqueStudentsByMentor($userId)
    {
        return $this->db->query(
            'SELECT 
                    students.id AS id,
                    students.fname AS fname
                    FROM users_students
                    JOIN students ON users_students.student_id = students.id
                    WHERE users_students.user_id = :id',
            [
                ':id' => $userId,
            ],
        )->get();
    }

    public function insertStudent($student)
    {
        return $this->db->query('INSERT INTO students(fname) VALUES(:fname)', [
            'fname' => ucfirst(strtolower($student)),
        ]);
    }

    public function insertMixStudentMentor($mentors, $studentId)
    {
        foreach ($mentors as $mentor) {
            $this->db->query('INSERT INTO users_students (user_id, student_id) VALUES(:user_id, :student_id)', [
                'user_id' => $mentor,
                'student_id' => $studentId,
            ]);
        }
    }

    public function delete($student)
    {
        $this->db->query('delete from students where id = :id', [
            'id' => $student,
        ]);
    }

    public function getStudentNameAndId($studentId)
    {
        return $this->db->query(
            '
                SELECT 
                students.fname AS student,
                students.id AS student_id
                FROM students 
                WHERE students.id = :student_id',
            [
                'student_id' => $studentId,
            ],
        )->find();
    }

    public function updateStudent($student)
    {
        $this->db->query('update students set fname = :fname where id = :id', [
            'fname' => $student['student_name'],
            'id' => $student['id'],
        ]);
    }

    public function deleteStudentWithMentors($id)
    {
        $this->db->query('DELETE FROM users_students WHERE student_id = :student_id', [
            'student_id' => $_POST['id'],
        ]);
    }


    public function updateMentors($selectedMentors)
    {
        foreach ($selectedMentors as $mentorId) {
            $this->db->query('INSERT INTO users_students (user_id, student_id) VALUES (:user_id, :student_id)', [
                'user_id' => $mentorId,
                'student_id' => $_POST['id'],
            ]);
        }
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
}