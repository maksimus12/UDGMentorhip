<?php

namespace Core;

//use Core\Database;

class Authenticator
{

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
                    'user_role' => $user['role']
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
            'user_role' => $user['user_role']
        ];

        session_regenerate_id(true);
    }

    public static function logout()
    {
        $_SESSION = [];
        session_destroy();
        $cookieParams = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 3600, $cookieParams['path'], $cookieParams['domain']);
    }

}