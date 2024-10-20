<?php

namespace Http\controllers\notifications;

use Http\models\Notification;
use Http\instance\UserInstance;

class NotificationsController
{
    public function showNotificationsBoard()
    {
        $notifications = new Notification();

        $results = $notifications->getAllUnreadNotificationsForManager(UserInstance::id());

        view("partials/notifications.view.php", [
            'heading' => 'Your Notifications',
            'notifications' => $results
        ]);
    }
}
