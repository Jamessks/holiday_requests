<?php

use Core\App;
use Core\Session;
use Core\Database;
use Core\Validator;
use Core\Middleware\Middleware;
use Http\instance\UserInstance;
use Http\models\HolidayRequest;

Middleware::resolve('employee', ['cancel_holiday_request']);

$userId = UserInstance::id();

$requestId = null;

if (isset($_POST['id'])) {
    $requestId = $_POST['id'];
}


if (!Validator::integer($_POST['id'])) {
    Session::flash('errors', 'Something went wrong with your request');
    header('location: /');
    exit();
}

$holidayRequest = new HolidayRequest();
$holidayRequestInfo = $holidayRequest->fetchSingleRequest($requestId);

if ($holidayRequestInfo['user_id'] != $userId) {
    Session::flash('errors', 'An error occured when trying to delete your holiday request.');
    header('location: /');
    exit();
}

if ($holidayRequestInfo['status'] != 'Pending') {
    Session::flash('errors', 'You can only cancel holiday requests that are in Pending status.');
    header('location: /');
    exit();
}

$holidayRequest->deleteSingleRequest($requestId);

Session::flash('success', 'Your holiday request was cancelled!');

header('location: /');
exit();
