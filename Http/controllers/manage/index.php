<?php

use Core\App;
use Core\Database;
use Http\models\User;

$db = App::resolve(Database::class);

$user = new User;

$users = $user->fetchManagedUsers();

view("manage/index.view.php", [
    'heading' => 'Users',
    'users' => $users
]);
