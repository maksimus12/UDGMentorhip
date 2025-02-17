<?php

namespace Core\Middleware;

use Exception;

class Middleware
{

    public const MAP = [

        'guest' => Guest::class,
        'auth' => Auth::class,
        'admin' => Admin::class,
    ];

    public static function resolve($key)
    {
        if (!$key) {
            return;
        }

        $middleware = static::MAP[$key] ?? false;

        if (!$middleware) {
            throw new Exception("No middleware found for the key: {$key}");
        }

        (new $middleware)->handler();
    }
}