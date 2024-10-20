<?php

namespace Http\instance;

class UserInstance
{
    public static function id()
    {
        if (!$_SESSION) {
            return false;
        }
        return $_SESSION['user']['id'] ?? null;
    }


    public static function username()
    {
        if (!$_SESSION) {
            return false;
        }
        return $_SESSION['user']['username'] ?? null;
    }

    public static function rbac($role, $permission)
    {
        if ($_SESSION && isset($_SESSION['user'])) {
            if ($_SESSION['user']['RBAC']['role'] === $role) {
                return in_array($permission, $_SESSION['user']['RBAC']['permissions']);
            }
        }
        return false;
    }

    public static function rbacPerms($permission)
    {
        if ($_SESSION && isset($_SESSION['user'])) {
            return in_array($permission, $_SESSION['user']['RBAC']['permissions']);
        }

        return false;
    }
}
