<?php

class Admin
{
    private $conn;

    public function __construct()
    {
       require_once __DIR__ . '/../config.php';
        global $mysqli;                // ✅ ambil koneksi global
        $this->conn = $mysqli;  
    }

    public function getCounts()
    {
        $counts = [];

        // Hitung total
        $tables = ['produk', 'users', 'transaksi'];
        foreach ($tables as $table) {
            $sql = "SELECT COUNT(*) as total FROM $table";
            $result = $this->conn->query($sql);
            $counts[$table] = $result->fetch_assoc()['total'];
        }

        // Breakdown status transaksi
        $sql = "SELECT 
                    SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) as paid,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN status = 'failed' THEN 1 ELSE 0 END) as failed,
                    SUM(CASE WHEN status = 'paid' THEN total ELSE 0 END) as pemasukan
                FROM transaksi";
        $result = $this->conn->query($sql);
        $counts['transaksi_status'] = $result->fetch_assoc();

        return $counts;
    }

    


}
