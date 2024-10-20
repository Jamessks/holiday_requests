<?php

use Core\Middleware\Middleware;
use Http\models\User;

$id = $_GET['user_id'];

if (!$id) {
    abort();
}

Middleware::resolve('manager', ['edit_employee']);

$user = new User;
$user = $user->fetchUserInfoOrFail($id);

view("manage/users/edit.view.php", [
    'heading' => 'Edit User',
    'errors' => [],
    'user' => $user
]);
