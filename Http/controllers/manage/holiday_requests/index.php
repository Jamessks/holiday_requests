<?php

use Core\Middleware\Middleware;
use Http\models\HolidayRequest;

Middleware::resolve('manager', ['view_employee']);

$holidayRequest = new HolidayRequest;

$holidayRequests = null;

$holidayRequests = $holidayRequest->fetchAllManagedHolidayRequests();

view("/manage/holiday_requests/index.view.php", [
    'heading' => 'Manage Holiday Requests',
    'holidayRequests' => $holidayRequests,
]);
