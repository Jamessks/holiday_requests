<?php

use Core\App;
use Core\Session;
use Core\Database;
use Core\Validator;
use Core\Middleware\Middleware;
use Http\models\User;

Middleware::resolve('manager', ['add_employee']);

$db = App::resolve(Database::class);

if (!isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['username']) || !isset($_POST['employee_code'])) {
    Session::flash('errors', ['Something went wrong with your request.']);
    header('location: /manage/users/create');
    exit();
}

$email = $_POST['email'];
$password = $_POST['password'];
$username = $_POST['username'];
$employee_code = $_POST['employee_code'];

$errors = [];

if (!Validator::email($email)) {
    $errors['email'] = 'Please provide a valid email address.';
}

if (!Validator::string($password, 7, 255)) {
    $errors['password'] = 'Please provide a password of at least seven characters.';
}

if (!Validator::string($username, 7, 255)) {
    $errors['username'] = 'Please provide a username of at least seven characters.';
}

if (!Validator::string($employee_code, 7, 7)) {
    $errors['username'] = 'Employee code must be up to 7 characters.';
}

if (Validator::integer($username)) {
    $errors['username'] = 'Please include characters in your name';
}

if (!empty($errors)) {
    if (!empty($errors)) {
        Session::flash('errors', $errors);
        header('location: /manage/users/create');
        exit();
    }
}

$user = new User;

$userEmail = $user->fetchUserByEmail($email);

$userName = $user->fetchUserByUsername($username);

$employee_code = $user->fetchUserByEmployeeCode($employee_code);

if ($userEmail) {
    $errors['email'] = 'The email is already in use by another user.';
}

if ($userName) {
    $errors['username'] = 'The username is already in use by another user.';
}

if ($employee_code) {
    $errors['employee_code'] = 'The employee code is already in use by another user.';
}

if (!empty($errors)) {
    Session::flash('errors', $errors);
    header('location: /manage/users/create');
    exit();
} else {
    try {
        $user->createUser($email, $password, $username, $employee_code);
    } catch (Exception $e) {
        $errors['username'] = $e->getMessage();
        Session::flash('errors', $errors);
        header('location: /manage/users/create');
        exit();
    }

    Session::flash('success', 'User registration complete!');

    header('location: /manage');
    exit();
}
