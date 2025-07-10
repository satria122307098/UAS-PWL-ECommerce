<?php

class User
{
    private $conn;

    public function __construct()
    {
        global $mysqli;
        $this->conn = $mysqli;
    }

    public function getByUsername($username)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($username, $nama, $password, $role = 'user')
    {
        $stmt = $this->conn->prepare("INSERT INTO users (username, nama, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $nama, $password, $role);
        return $stmt->execute();
    }

}
