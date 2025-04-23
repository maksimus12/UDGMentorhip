<?php

namespace Http\models;

use Core\BasicModel;

class UserModel extends BasicModel
{
    public function getAll()
    {
        return $this->db->query("SELECT * FROM users")->get();
    }

    public function getMentorNameAndId($mentorId)
    {
        return $this->db->query(
            'SELECT 
                users.id AS user_id,
                users.email AS mentor_email
                FROM users_students 
                JOIN users ON users_students.user_id = users.id
                WHERE users_students.student_id = :student_id',
            [
                'student_id' => $mentorId,
            ],
        )->get();
    }
}