<?php

namespace Http\models;

use Core\App;
use Core\Database;

class HolidayRequest
{
    protected $db;
    public static $notifiableRoles = [
        'manager'
    ];

    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }

    public function getNotifiableRolesUsers($notifiableRoles)
    {
        $placeholders = rtrim(str_repeat('?,', count($notifiableRoles)), ',');
        $query = "SELECT DISTINCT u.id FROM users u 
                  JOIN role_user ru ON u.id = ru.user_id 
                  JOIN roles r ON ru.role_id = r.id 
                  WHERE r.name IN ($placeholders)";

        $results = $this->db->query($query, $notifiableRoles)->get();

        return $results;
    }

    public function loadLeaveReasons()
    {
        $results = $this->db->query('SELECT id, name FROM leave_reasons ORDER BY id ASC', [])->get();

        return $results;
    }

    public function fetchSingleRequest($id)
    {
        $results = $this->db->query('SELECT id, user_id, status FROM holiday_requests WHERE id = :id', [
            'id' => $id
        ])->findOrFail();

        return $results;
    }

    public function deleteSingleRequest($id)
    {
        $this->db->query('DELETE FROM holiday_requests WHERE id = :id', [
            'id' => $id
        ]);
    }

    public function findLeaveReason($id)
    {
        $results = $this->db->query(
            'SELECT id FROM leave_reasons WHERE id = :id',
            ['id' => $id]
        )->find();

        return $results;
    }

    public function findSingleHolidayRequestOrFail($id)
    {
        $results = $this->db->query('select * from holiday_requests where id = :id', [
            'id' => $id
        ])->findOrFail();
    }
    public function findConflictingDates($user_id, $from_date, $to_date)
    {
        $results = $this->db->query('SELECT COUNT(*) as conflicts 
                FROM holiday_requests
                WHERE user_id = :user_id
                AND status = "Pending"
                AND (
                    (:from_date BETWEEN from_date AND to_date)
                    OR (:to_date BETWEEN from_date AND to_date)
                    OR (from_date BETWEEN :from_date AND :to_date)
                    OR (to_date BETWEEN :from_date AND :to_date)
                )', [
            'user_id' => $user_id,
            'from_date' => $from_date,
            'to_date' => $to_date
        ])->find();

        return $results;
    }

    public function insertRequest($from_date, $to_date, $user_id, $reason_id)
    {
        $this->db->query('INSERT INTO holiday_requests(from_date, to_date, user_id, reason_id) VALUES(:from_date, :to_date, :user_id, :reason_id)', [
            'from_date' => $from_date,
            'to_date' => $to_date,
            'user_id' => $user_id,
            'reason_id' => $reason_id
        ]);
    }

    public function updateRequestToStatus($requestId, $status)
    {
        $this->db->query('UPDATE holiday_requests SET status = :status WHERE id = :id', [
            'status' => $status,
            'id' => $requestId
        ]);
    }

    public function fetchAllManagedHolidayRequests()
    {
        $results = $this->db->query('SELECT
        hr.id, 
        hr.from_date, 
        hr.to_date, 
        lr.name AS reason,
        hr.created_at, 
        hr.status,
        hr.user_id,
        u.username
        FROM holiday_requests hr
        JOIN leave_reasons lr ON hr.reason_id = lr.id
        JOIN users u ON hr.user_id = u.id', [])->get();


        return $results;
    }
}
