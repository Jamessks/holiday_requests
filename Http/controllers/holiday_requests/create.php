<?php

use Core\App;
use Core\Database;
use Http\models\HolidayRequest;

$holidayRequest = new HolidayRequest;
$reasons = $holidayRequest->loadLeaveReasons();

view("holiday_requests/create.view.php", [
    'heading' => 'Create Holiday Request',
    'reasons' => $reasons ?? null,
    'errors' => []
]);
