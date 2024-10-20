<?php

use Core\App;
use Core\Database;
use Core\Middleware\Middleware;
use Core\Validator;
use Http\instance\UserInstance;
use Http\models\Notification;

$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody, true);

Middleware::resolve('manager', ['manage_notifications'], false);

if (!Validator::integer($data['notificationId']) || !isset($data['notificationId'])) {
    $response['error'] = 'Wrong data received.';
    http_response_code(400);
    echo json_encode($response);
    exit();
}

$db = App::resolve(Database::class);

$notification = $db->query('SELECT id FROM notifications WHERE id = :id', [
    'id' => $data['notificationId']
])->get();

if (!$notification) {
    $response['error'] = 'The notification was not found.';
    http_response_code(400);
    echo json_encode($response);
    exit();
}

$notify = new Notification;

$notify->markNotificationAsRead($data['notificationId']);

$countNotifications = $notify->getAllNotificationsForManagerCount(UserInstance::id());

$response['success'] = true;
$response['message'] = 'Notification marked as read.';
$response['count'] = $countNotifications;

echo json_encode($response);
