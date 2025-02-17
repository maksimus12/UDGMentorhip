<?php

namespace Core\Middleware;

class Admin
{
    public function handler()
    {
        if (!\Core\Session::isAdmin() ?? false) {
            header('Location: /login');
            die();
        }
    }
}