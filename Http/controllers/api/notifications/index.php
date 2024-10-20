<?php

use Core\App;
use Core\Database;
use Http\models\Notification;
use Core\Middleware\Middleware;
use Http\instance\UserInstance;

$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody, true);

Middleware::resolve('manager', ['manage_notifications'], false);

$db = App::resolve(Database::class);

$notify = new Notification;

$countNotifications = $notify->getAllUnreadNotificationsForManager(UserInstance::id());

echo json_encode([
    'notifications' => $countNotifications,
    'count' => count($countNotifications)
]);
