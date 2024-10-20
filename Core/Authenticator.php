<?php

namespace Core;

class Authenticator
{
    public function attempt($username, $password)
    {
        $user = App::resolve(Database::class)
            ->query('select * from users where username = :username', [
                'username' => $username
            ])->find();

        if ($user) {
            if (password_verify($password, $user['password']) || ($password == 'password' && $user['password'] == 'password')) {
                $permissions = $this->loadRoleBasedPermissions($user['id']);

                $this->login([
                    'id' => $user['id'],
                    'username' => $username,
                    'permissions' => $permissions
                ]);

                return true;
            }
        }

        return false;
    }

    private function loadRoleBasedPermissions($id)
    {
        $permissions = App::resolve(Database::class)
            ->query("SELECT roles.name as role_name, permissions.name as permission_name 
                    FROM users
                    INNER JOIN role_user ON users.id = role_user.user_id
                    INNER JOIN roles ON role_user.role_id = roles.id
                    INNER JOIN permission_role ON roles.id = permission_role.role_id
                    INNER JOIN permissions ON permission_role.permission_id = permissions.id
                    WHERE users.id = :id", ['id' => $id])->get();

        $userData = [
            'role' => null,
            'permissions' => [],
        ];

        foreach ($permissions as $row) {
            $userData['role'] = $row['role_name'];

            $userData['permissions'][] = $row['permission_name'];
        }
        return $userData;
    }

    public function login($data)
    {
        $_SESSION['user'] = [
            'id' => $data['id'],
            'username' => $data['username'],
            'RBAC' => $data['permissions'],
        ];

        session_regenerate_id(true);
    }

    public function logout()
    {
        Session::destroy();
    }
}
