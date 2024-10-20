<?php

use Core\Authenticator;
use Http\Forms\LoginForm;

$form = LoginForm::validate($attributes = [
    'username' => $_POST['username'],
    'password' => $_POST['password']
]);
$signedIn = (new Authenticator)->attempt(
    $attributes['username'],
    $attributes['password']
);

if (!$signedIn) {
    $form->error(
        'username',
        'Username and password do not match.'
    )->throw();
}

redirect('/');
