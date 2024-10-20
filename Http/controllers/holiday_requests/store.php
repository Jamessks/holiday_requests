<?php

use Core\Session;
use Core\Validator;
use Core\Middleware\Middleware;
use Http\instance\UserInstance;
use Http\models\HolidayRequest;
use Http\models\Notification;

Middleware::resolve('employee', ['make_holiday_request']);

$id = UserInstance::id();

$errors = [];

$holidayRequest = new HolidayRequest;

if (empty($_POST['from_date'])) {
    $errors['from_date'] = 'The \'from\' date is required.';
} elseif (!Validator::date($_POST['from_date'])) {
    $errors['from_date'] = 'Please provide a valid \'from\' date.';
}

if (empty($_POST['to_date'])) {
    $errors['to_date'] = 'The \'to\' date is required.';
} elseif (!Validator::date($_POST['to_date'])) {
    $errors['to_date'] = 'Please provide a valid \'to\' date.';
}

if (empty($_POST['reason'])) {
    $errors['reason'] = 'The reason is required.';
} elseif (!Validator::integer($_POST['reason'])) {
    $errors['reason'] = 'Please provide a valid reason.';
} else {
    $reasonExists = $holidayRequest->findLeaveReason($id);

    if (!$reasonExists) {
        $errors['reason'] = 'The selected reason is invalid.';
    }
}

if (isset($_POST['from_date'], $_POST['to_date']) && !isset($errors['from_date']) && !isset($errors['to_date'])) {
    if ($_POST['from_date'] > $_POST['to_date']) {
        $errors['from_date'] = '\'From\' Date cannot be greater than \'To\' date.';
    }
}

if (!isset($errors['from_date']) && !isset($errors['to_date'])) {
    $date = $holidayRequest->findConflictingDates($id, $_POST['from_date'], $_POST['to_date']);

    if ($date['conflicts'] > 0) {
        $errors['from_date'] = "Conflicting date with another holiday request detected";
    }
}

if (!empty($errors)) {
    Session::flash('errors', $errors);
    header('location: /holiday-request/create');
    exit();
}

$holidayRequest->insertRequest($_POST['from_date'], $_POST['to_date'], $id, $_POST['reason']);

$notifiableUsers = $holidayRequest->getNotifiableRolesUsers(HolidayRequest::$notifiableRoles);

$notification = new Notification();
$notification->createNotification(UserInstance::username() . ' has requested a vacation leave', 'holiday_request', $notifiableUsers);

Session::flash('success', 'Your holiday request has been submitted. Good Luck!');

header('location: /');
die();
