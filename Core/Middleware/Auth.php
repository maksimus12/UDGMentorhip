<?php

namespace Core\Middleware;

class Auth
{

    public function handler()
    {
        if (!$_SESSION['user'] ?? false) {
            header('Location: /');
            die();
        }
    }
}