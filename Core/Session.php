<?php

namespace Core;

use Core\UserRoles;

class Session
{
    public static function has($key)
    {
        return (bool)static::get($key);
    }

    public static function put($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null)
    {
        return $_SESSION['_flash'][$key] ?? $_SESSION[$key] ?? $default;
    }

    public static function flash($key, $value)
    {
        $_SESSION['_flash'][$key] = $value;
    }

    public static function unflash()
    {
        unset($_SESSION['_flash']);
    }

    public static function flush()
    {
        $_SESSION = [];
    }

    public static function isAuthenticated()
    {
        return static::has('user');
    }

    public static function getUser()
    {
        return static::get('user');
    }

    public static function getUserId()
    {
        $user = static::get('user');
        return $user['user_id'] ?? null;
    }

    public static function isAdmin()
    {
        $user = static::getUser();
        return $user['user_role'] === UserRoles::ADMIN;
    }

    public static function destroy()
    {
        static::flush();
        session_destroy();
        $cookieParams = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 3600, $cookieParams['path'], $cookieParams['domain']);
    }
}
