<?php

use Core\Response;

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

function urlIs($value)
{
    return $_SERVER['REQUEST_URI'] === $value;
}

function  abort($code = 404) {
    http_response_code($code);

    require base_path("views/{$code}.php");

    die();
}


function authorize($condition, $status = Response::FORBIDDEN)
{
    if (! $condition) {
        abort($status);
    }
}

function base_path($path)
{
    return BASE_PATH . $path;
}

function view($path, $attributes = [])
{
    extract($attributes);

    require_once base_path('views/' . $path);
}

function login($user)
{
    $_SESSION['user'] = [
        'user_id' => $user['user_id'],
        'email' => $user['email'],
        'user_role'=>$user['user_role']
    ];

    session_regenerate_id(true);
}

function logout(){
    $_SESSION =[];
    session_destroy();
    $cookieParams = session_get_cookie_params();
    setcookie('PHPSESSID', '', time() - 3600, $cookieParams['path'], $cookieParams['domain']);
}