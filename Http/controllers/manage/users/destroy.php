<?php

use Core\Session;
use Core\Validator;
use Http\models\User;
use Core\Middleware\Middleware;

Middleware::resolve('manager', ['delete_employee']);

$id = null;

if (isset($_POST['user_id'])) {
    $id = $_POST['user_id'];
}

if (!Validator::integer($id)) {
    Session::flash('errors', 'Something went wrong with your request');
    header('location: /');
    exit();
}


if ($id == $_SESSION['user']['id']) {
    Session::flash('notification', 'You cannot perform this action on yourself.');
    header('location: /manage');
    exit();
}

$user = new User;
$user->fetchUserOrFail($id);
$user->deleteUser($id);

Session::flash('success', 'User was deleted successfully!');

header('location: /manage');
exit();
