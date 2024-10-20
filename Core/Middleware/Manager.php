<?php

namespace Core\Middleware;

class Manager
{
    public function handle($permissions = [], $redirect = true)
    {
        if (! $_SESSION['user'] ?? false) {
            header('location: /');
            exit();
        }

        if ($_SESSION['user']['RBAC']['role'] != 'manager') {
            $redirect ? abort(403) : exit;
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
                $redirect ? abort(403) : exit;
            }
        }
    }
}
