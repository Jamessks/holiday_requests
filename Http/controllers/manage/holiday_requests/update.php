<?php

use Core\Validator;
use Core\Middleware\Middleware;
use Core\Session;
use Http\models\HolidayRequest;

$requestId = $_POST['request_id'] ?? null;
$status = $_POST['status'] ?? null;

$statuses = ['approve_holiday_request', 'reject_holiday_request'];

if (!Validator::integer($status)) {
    $errors['status'] = 'Something went wrong. Please try again.';
}

if (!Validator::integer($requestId)) {
    $errors['request_id'] = 'The holiday request was not found.';
}

if (!empty($errors)) {
    Session::flash('errors', $errors);
    header('Location: /manage/holiday-request');
    exit();
}


$holidayRequest = new HolidayRequest;

$holidayRequestFound = $holidayRequest->findSingleHolidayRequestOrFail($requestId);

Middleware::resolve('manager', [$statuses[$status]]);

$statusEnum = [
    0 => 'Rejected',
    1 => 'Approved'
];

$status = $statusEnum[$_POST['status']];

$holidayRequest->updateRequestToStatus($requestId, $status);


Session::flash('success', 'Holiday request status updated successfully!');
header('location: /manage/holiday-request');
exit();
