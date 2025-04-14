<?php

namespace Http\Models;

use Core\BasicModel;

class StudentModel extends BasicModel
{
    public function getStudentsWithMenthors()
    {
        return $this->db->query("
            SELECT
                students.fname AS student, 
                COALESCE(GROUP_CONCAT(users.email), 'No mentor') AS mentor,
                students.id AS student_id
            FROM students
            LEFT JOIN users_students ON students.id = users_students.student_id
            LEFT JOIN users ON users_students.user_id = users.id
            GROUP BY students.id
        ")->get();
    }

    public function deleteById(int $id)
    {
        $this->db->query('delete from students where id = :id', [
            'id' => $id
        ]);
    }
}
