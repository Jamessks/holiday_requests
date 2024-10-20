<?php

namespace Core\Middleware;

class Employee
{
    public function handle()
    {
        if (! $_SESSION['user'] ?? false) {
            header('location: /');
            exit();
        }

        if ($_SESSION['user']['RBAC']['role'] != 'employee') {
            abort(403);
        }

        if (!empty($permissions)) {
            $flag = true;

            foreach ($permissions as $permission) {
                if (!in_array($permission, $_SESSION['user']['RBAC']['permissions'])) {
                    $flag = false;
                    break;
                }
            }

            if (!$flag) {
                abort(403);
            }
        }
    }
}
