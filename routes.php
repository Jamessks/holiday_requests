<?php

$router->get('/', 'index.php');

$router->get('/about', 'about.php');
$router->get('/contact', 'contact.php');

$router->get('/manage', 'manage/index.php')->only('manager');

$router->get('/manage/users/create', 'manage/users/create.php')->only('manager');
$router->post('/manage/users', 'manage/users/store.php')->only('manager');

$router->get('/manage/users/edit', 'manage/users/edit.php')->only('manager');
$router->patch('/manage/users', 'manage/users/update.php')->only('manager');

// TODO: Change this to /manage/users
$router->delete('/manage/users/destroy', 'manage/users/destroy.php')->only('manager');

$router->get('/manage/holiday-request', 'manage/holiday_requests/index.php')->only('manager');
$router->patch('/manage/holiday-request', 'manage/holiday_requests/update.php')->only('manager');

$router->get('/holiday-request/create', 'holiday_requests/create.php')->only('employee');
$router->post('/holiday-request', 'holiday_requests/store.php')->only('employee');
$router->delete('/holiday-request', 'holiday_requests/destroy.php')->only('employee');

$router->patch('/api/notifications', 'api/notifications/update.php')->only('manager');
$router->get('/api/notifications', 'api/notifications/index.php')->only('manager');

$router->get('/login', 'session/create.php')->only('guest');
$router->post('/session', 'session/store.php')->only('guest');
$router->delete('/session', 'session/destroy.php')->only('auth');
