<?php

namespace Http\models;

use Core\App;
use Core\Database;

class Notification
{
    protected $db;

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }

    public function createNotification($message, $type, $managerIds = [])
    {
        $flattenedIds = array_map(fn($manager) => $manager['id'], $managerIds);

        $placeholders = rtrim(str_repeat('(?, ?, ?), ', count($flattenedIds)), ', ');

        $sql = "INSERT INTO notifications (message, manager_id, type) VALUES $placeholders";

        $params = [];
        foreach ($flattenedIds as $id) {
            $params[] = $message;
            $params[] = $id;
            $params[] = $type;
        }

        return $this->db->query($sql, $params);
    }

    public function getAllUnreadNotificationsForManager($managerId)
    {
        $results =  $this->db->query('SELECT * FROM notifications WHERE manager_id = :manager_id AND read_status = 0 ORDER BY created_at DESC', [
            'manager_id' => $managerId,
        ])->get();

        return $results;
    }

    public function getAllNotificationsForManagerCount($managerId)
    {
        $results =  $this->db->query(
            'SELECT COUNT(*) AS count
            FROM notifications
            WHERE manager_id = :manager_id
            AND read_status = 0',
            [
                'manager_id' => $managerId,
            ]
        )->find();

        return $results['count'];
    }

    public function markNotificationAsRead($notificationId)
    {
        $results = $this->db->query('UPDATE notifications SET read_status = 1 WHERE id = :id', [
            'id' => $notificationId
        ]);

        return $results;
    }

    public function delete($notificationId)
    {

        $results = $this->db->query('DELETE FROM notifications WHERE id = :id', [
            'id' => $notificationId,
        ]);

        return $results;
    }
}
