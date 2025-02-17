<?php

namespace Core;


class Authenticator
{

    public static function logout()
    {
        Session::destroy();
    }

    public function attempt($email, $password)
    {
        $user = App::resolve(Database::class)->query('select * from users where email = :email', [
            'email' => $email,
        ])->find();
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $this->login([
                    'user_id' => $user['id'],
                    'email' => $user['email'],
                    'user_role' => $user['role'],
                ]);
                return true;
            }
        }
        return false;
    }

    public function login($user)
    {
        $_SESSION['user'] = [
            'user_id' => $user['user_id'],
            'email' => $user['email'],
            'user_role' => $user['user_role'],
        ];

        session_regenerate_id(true);
    }

}