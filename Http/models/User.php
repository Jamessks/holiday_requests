<?php

namespace Http\models;

use Core\App;
use Exception;
use Core\Database;

class User
{
    protected $db;

    /**
     * Constructor method for initializing the database connection.
     */
    public function __construct()
    {
        $this->db = App::resolve(Database::class);
    }

    /**
     * Fetches a user by ID or throws an exception if the user is not found.
     *
     * @param int $id The ID of the user to fetch.
     * @return array The user details (typically ID) if found.
     * @throws Exception If no user is found for the provided ID.
     */
    public function fetchUserOrFail(int $id)
    {
        $results = $this->db->query('SELECT id FROM users WHERE id = :id', [
            'id' => $id
        ])->findOrFail();

        return $results;
    }

    /**
     * Deletes a user from the database by ID.
     *
     * @param int $id The ID of the user to delete.
     * @return void
     */
    public function deleteUser(int $id)
    {
        $this->db->query('DELETE FROM users WHERE id = :id', [
            'id' => $id
        ]);
    }

    /**
     * Fetches basic user information (ID, email, username) by ID or throws an exception if not found.
     *
     * @param int $id The ID of the user to fetch.
     * @return array The user details including ID, email, and username if found.
     * @throws Exception If no user is found for the provided ID.
     */
    public function fetchUserInfoOrFail(int $id)
    {
        $results = $this->db->query('SELECT id, email, username FROM users WHERE id = :id', [
            'id' => $id
        ])->findOrFail();

        return $results;
    }

    /**
     * Fetches a user by their email address.
     *
     * @param string $email The email of the user to fetch.
     * @return array|null The user details if found, or null if no user is found.
     */
    public function fetchUserByEmail(string $email)
    {
        $results = $this->db->query('SELECT * FROM users WHERE email = :email', [
            'email' => $email
        ])->find();

        return $results;
    }

    /**
     * Fetches a user by their username.
     *
     * @param string $username The username of the user to fetch.
     * @return array|null The user details if found, or null if no user is found.
     */
    public function fetchUserByUsername(string $username)
    {
        $results = $this->db->query('SELECT * FROM users WHERE username = :username', [
            'username' => $username
        ])->find();

        return $results;
    }

    /**
     * Fetches a user by their employee code.
     *
     * @param string $employee_code The employee code of the user to fetch.
     * @return array|null The user details if found, or null if no user is found.
     */
    public function fetchUserByEmployeeCode(string $employee_code)
    {
        $results = $this->db->query('SELECT * FROM users WHERE employee_code = :employee_code', [
            'employee_code' => $employee_code
        ])->find();

        return $results;
    }

    /**
     * Fetches a user by ID or throws an exception if the user is not found.
     *
     * @param int $id The ID of the user to fetch.
     * @return array The user details if found.
     * @throws Exception If no user is found for the provided ID.
     */
    public function fetchUserByIdOrFail(int $id)
    {
        return $this->db->query('SELECT * FROM users WHERE id = :id', [
            'id' => $id
        ])->findOrFail();
    }

    /**
     * Creates a new user and assigns a default role to the user.
     *
     * @param string $email The email of the user to create.
     * @param string $password The password of the user.
     * @param string $username The username of the user.
     * @param string $employee_code The employee code of the user.
     * @return bool True on success.
     * @throws Exception If the user creation fails or any database error occurs.
     */
    public function createUser($email, $password, $username, $employee_code)
    {
        try {
            $this->db->beginTransaction();

            $this->db->query('INSERT INTO users(email, password, username, employee_code) VALUES(:email, :password, :username, :employee_code)', [
                'email' => $email,
                'password' => password_hash($password, PASSWORD_BCRYPT),
                'username' => $username,
                'employee_code' => $employee_code
            ]);

            $lastInsertId = $this->db->lastInsertId();

            $this->db->query('INSERT INTO role_user(user_id, role_id) VALUES(:user_id, :role_id)', [
                'user_id' => $lastInsertId,
                'role_id' => 1
            ]);

            $this->db->commit();

            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception('Database error: ' . $e->getMessage());
        }
    }

    /**
     * Updates a user's information in the database.
     *
     * @param int $id The ID of the user to update.
     * @param string $email The new email of the user.
     * @param string $username The new username of the user.
     * @param string $password The new password of the user.
     * @return void
     */
    public function updateUser($id, $email, $username, $password)
    {
        $this->db->query('UPDATE users SET email = :email, username = :username, password = :password WHERE id = :id', [
            'id' => $id,
            'email' => $email,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT),
        ]);
    }

    /**
     * Fetches all users' basic information from the database.
     *
     * @return array An array of users with their ID, username, and email.
     */
    public function fetchManagedUsers()
    {
        $results = $this->db->query('SELECT id, username, email FROM users')->get();

        return $results;
    }
}
