<?php

namespace Http\models;

use Core\BasicModel;
use Core\UserRoles;

class UserModel extends BasicModel
{
    public function getAll()
    {
        return $this->db->query("SELECT * FROM users")->get();
    }

    public function findUserByEmail($email)
    {
        return $this->db->query('select * from users where email= :email', [
            'email' => $email,
        ])->find();
    }

    public function findUserById($id)
    {
        return $this->db->query('SELECT * FROM users WHERE id = :id', ['id' => $id])->find();
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

    public function deleteUser($userId)
    {
        return $this->db->query('update users set is_deleted = 1 where id = :id', [
            'id' => $userId,
        ]);
    }

    public function createNewUser($email, $password, $role)
    {
        return $this->db->query('INSERT INTO users(email, password, role) VALUES(:email, :password, :role)', [
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role,
        ]);
    }

    public function updateUserInfo($email, $role, $status, $id)
    {
        $this->db->query('update users set email = :email, role = :role, is_deleted = :is_deleted  where id = :id', [
            'email' => $email,
            'role' => $role,
            'is_deleted' => $status,
            'id' => $id,
        ]);
    }

    public function updateUserPassword($password, $id)
    {
        return $this->db->query('update users set password = :password  where id = :id', [
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'id' => $id,
        ]);
    }
}