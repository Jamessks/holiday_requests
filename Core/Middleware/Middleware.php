<?php

namespace Core\Middleware;

use Core\Middleware\Employee;
use Core\Middleware\Manager;
use Core\Middleware\Guest;
use Core\Middleware\Authenticated;

class Middleware
{
    public const MAP = [
        'guest' => Guest::class,
        'auth' => Authenticated::class,
        'employee' => Employee::class,
        'manager' => Manager::class
    ];

    public static function resolve($key, $permissions = [], $redirect = true)
    {
        if (!$key) {
            return;
        }

        $middleware = static::MAP[$key] ?? false;

        if (!$middleware) {
            throw new \Exception("No matching middleware found for key '{$key}'.");
        }

        (new $middleware)->handle($permissions, $redirect);
    }
}
