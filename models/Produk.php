<?php

class Produk
{
    private $conn;

    public function __construct()
    {
        global $mysqli;
        $this->conn = $mysqli;
    }

    public function getAll()
    {
        $result = $this->conn->query("SELECT * FROM produk ORDER BY idproduk DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM produk WHERE idproduk = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function insert($nama, $kategori, $shortdesc, $deskripsi, $harga, $berat, $gambar)
    {
        $stmt = $this->conn->prepare("INSERT INTO produk (nama, kategori, shortdesc, deskripsi, harga, berat, gambar) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssdss", $nama, $kategori, $shortdesc, $deskripsi, $harga, $berat, $gambar);
        return $stmt->execute();
    }

    public function update($id, $nama, $kategori, $shortdesc, $deskripsi, $harga, $berat, $gambar)
    {
        $stmt = $this->conn->prepare("UPDATE produk SET nama=?, kategori=?, shortdesc=?, deskripsi=?, harga=?, berat=?, gambar=? WHERE idproduk=?");
        $stmt->bind_param("ssssdssi", $nama, $kategori, $shortdesc, $deskripsi, $harga, $berat, $gambar, $id);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM produk WHERE idproduk = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function searchByKeyword($keyword)
    {
        $keyword = '%' . $this->conn->real_escape_string($keyword) . '%';
        $stmt = $this->conn->prepare("SELECT * FROM produk WHERE nama LIKE ?");
        $stmt->bind_param("s", $keyword);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }


}
