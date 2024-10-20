<?php

use Core\App;
use Core\Database;
use Http\instance\UserInstance;

if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit();
}

if ($_SESSION['user']['RBAC']['role'] === 'manager') {
    header('Location: /manage');
    exit();
}

$db = App::resolve(Database::class);

if ($id = UserInstance::id()) {
    $holidayRequests = $db->query('SELECT
    hr.id, 
    hr.from_date, 
    hr.to_date, 
    lr.name AS reason,
    hr.created_at, 
    hr.status 
FROM
    holiday_requests hr
JOIN
    leave_reasons lr ON hr.reason_id = lr.id
WHERE
    hr.user_id = :id ORDER BY created_at DESC;', [
        'id' => $id
    ])->get();
}

view("index.view.php", [
    'heading' => 'Your Holiday Requests',
    'holidayRequests' => $holidayRequests ?? null,
]);
