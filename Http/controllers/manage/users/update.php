<?php

use Core\App;
use Core\Session;
use Core\Database;
use Core\Validator;
use Http\models\User;
use Core\Middleware\Middleware;

Middleware::resolve('manager', ['edit_employee']);

$db = App::resolve(Database::class);

$errors = [];


if (!Validator::integer($_POST['id'])) {
    Session::flash('errors', ['Something went wrong with your request']);
    header('location: /manage');
    exit();
}

$user = new User;

$userExists = $user->fetchUserByIdOrFail($_POST['id']);


if (!Validator::email($_POST['email'])) {
    $errors['email'] = 'Please provide a valid email address.';
}

if (!Validator::string($_POST['password'], 7, 255)) {
    $errors['password'] = 'Please provide a password of at least seven characters.';
}

if (!Validator::string($_POST['username'], 7, 255)) {
    $errors['username'] = 'Please provide a username of at least seven characters.';
}

if (!empty($errors)) {
    Session::flash('errors', $errors);
    header('location: /manage/users/edit?user_id=' . $_POST['id']);
    exit();
}

$userEmail = $db->query('SELECT * FROM users WHERE email = :email AND id != :id', [
    'email' => $_POST['email'],
    'id' => $_POST['id']
])->find();

$userName = $db->query('SELECT * FROM users WHERE username = :username AND id != :id', [
    'username' => $_POST['username'],
    'id' => $_POST['id']
])->find();

if ($userEmail) {
    $errors['email'] = 'The email is already in use by another user.';
}

if ($userName) {
    $errors['username'] = 'The username is already in use by another user.';
}

if ($userEmail || $userName) {
    Session::flash('errors', $errors);
    header('location: /manage/users/edit?user_id=' . $_POST['id']);
    exit();
}

$user->updateUser($_POST['id'], $_POST['email'], $_POST['username'], $_POST['password']);

Session::flash('success', 'User edited successfully!');

header('location: /manage');
die();
