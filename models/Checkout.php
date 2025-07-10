<?php

class Checkout
{
    private $conn;

    public function __construct()
    {
        global $mysqli;
        $this->conn = $mysqli;
    }

    public function simpanTransaksi($iduser, $nama, $alamat, $total, $snapToken, $cart)
    {
        $stmt = $this->conn->prepare("INSERT INTO transaksi (iduser, nama, alamat, total, snap_token) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issis", $iduser, $nama, $alamat, $total, $snapToken);
        $stmt->execute();
        $idtransaksi = $stmt->insert_id;

        $detail = $this->conn->prepare("INSERT INTO transaksi_detail (idtransaksi, idproduk, nama_produk, harga, qty, subtotal) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($cart as $id => $item) {
            $subtotal = $item['qty'] * $item['harga'];
            $detail->bind_param("iisiii", $idtransaksi, $id, $item['nama'], $item['harga'], $item['qty'], $subtotal);
            $detail->execute();
        }

        return $idtransaksi;
    }


    public function getDetailTransaksi($idtransaksi)
    {
        $stmt = $this->conn->prepare("SELECT * FROM transaksi_detail WHERE idtransaksi = ?");
        $stmt->bind_param("i", $idtransaksi);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }


    public function getTransaksiByUser($iduser)
    {
        $stmt = $this->conn->prepare("SELECT * FROM transaksi WHERE iduser = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $iduser);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateSnapToken($idtransaksi, $token)
    {
        $stmt = $this->conn->prepare("UPDATE transaksi SET snap_token = ? WHERE idtransaksi = ?");
        $stmt->bind_param("si", $token, $idtransaksi);
        $stmt->execute();
    }

    public function getTransaksiById($idtransaksi)
    {
        $stmt = $this->conn->prepare("SELECT * FROM transaksi WHERE idtransaksi = ?");
        $stmt->bind_param("i", $idtransaksi);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getAllTransaksi()
    {
        $sql = "SELECT t.*, u.nama as nama_user 
                FROM transaksi t 
                JOIN users u ON t.iduser = u.iduser 
                ORDER BY t.created_at DESC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }




}
