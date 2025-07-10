<?php

class AdminController
{
    public function __construct()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?c=UserController&m=login');
            exit;
        }
    }

    public function dashboard()
    {
        require_once 'models/Admin.php';
        $admin = new Admin();
        $data = $admin->getCounts();

        include 'views/template/header.php';
        include 'views/admin/dashboard.php';
        //include 'views/template/footer.php';
    }

    public function transaksi()
    {
        require_once 'models/Checkout.php';
        $checkout = new Checkout();
        $data = $checkout->getAllTransaksi();

        include 'views/template/header.php';
        include 'views/admin/transaksi.php';
        include 'views/template/footer.php';
    }

    public function tambah()
    {
        include 'views/template/header.php';
        include 'views/admin/tambah_produk.php';
        include 'views/template/footer.php';
    }

    public function simpan()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'models/Produk.php';

            $nama       = trim(strip_tags($_POST['nama']));
            $kategori   = trim(strip_tags($_POST['kategori']));
            $shortdesc  = trim(strip_tags($_POST['shortdesc']));
            $deskripsi  = trim(strip_tags($_POST['deskripsi']));
            $harga      = (int) $_POST['harga'];
            $berat      = (float) $_POST['berat'];
            $gambar     = null;

            if (!empty($_FILES['gambar']['name'])) {
                $mime = mime_content_type($_FILES['gambar']['tmp_name']);
                $allowed = ['image/jpeg', 'image/png', 'image/webp'];

                if (in_array($mime, $allowed)) {
                    $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
                    $filename = time() . '_' . rand(1000, 9999) . '.' . $ext;
                    $target = 'assets/img/' . $filename;

                    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
                        $gambar = $filename;
                    }
                } else {
                    $_SESSION['error'] = "Format file tidak diizinkan.";
                    header('Location: index.php?c=AdminController&m=tambah');
                    exit;
                }
            }

            $produkModel = new Produk();
            $produkModel->insert($nama, $kategori, $shortdesc, $deskripsi, $harga, $berat, $gambar);

            header('Location: index.php?c=AdminController&m=produk');
            exit;
        }
    }

    public function edit()
    {
        if (!isset($_GET['id'])) {
            echo "ID produk tidak ditemukan.";
            return;
        }

        require_once 'models/Produk.php';
        $produkModel = new Produk();
        $produk = $produkModel->getById((int)$_GET['id']);

        include 'views/template/header.php';
        include 'views/admin/edit_produk.php';
        include 'views/template/footer.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'models/Produk.php';

            $id         = (int) $_POST['id'];
            $nama       = trim(strip_tags($_POST['nama']));
            $kategori   = trim(strip_tags($_POST['kategori']));
            $shortdesc  = trim(strip_tags($_POST['shortdesc']));
            $deskripsi  = trim(strip_tags($_POST['deskripsi']));
            $harga      = (int) $_POST['harga'];
            $berat      = (float) $_POST['berat'];
            $gambar     = $_POST['gambar_lama'] ?? null;

            if (!empty($_FILES['gambar']['name'])) {
                $mime = mime_content_type($_FILES['gambar']['tmp_name']);
                $allowed = ['image/jpeg', 'image/png', 'image/webp'];

                if (in_array($mime, $allowed)) {
                    $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
                    $filename = time() . '_' . rand(1000, 9999) . '.' . $ext;
                    $target = 'assets/img/' . $filename;

                    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
                        $gambar = $filename;
                    }
                } else {
                    $_SESSION['error'] = "Format file tidak diizinkan.";
                    header('Location: index.php?c=AdminController&m=edit&id=' . $id);
                    exit;
                }
            }

            $produkModel = new Produk();
            $produkModel->update($id, $nama, $kategori, $shortdesc, $deskripsi, $harga, $berat, $gambar);

            header('Location: index.php?c=AdminController&m=produk');
            exit;
        }
    }

    public function detail()
    {
        if (!isset($_GET['id'])) {
            echo "ID produk tidak ditemukan.";
            return;
        }

        require_once 'models/Produk.php';
        $produkModel = new Produk();
        $produk = $produkModel->getById((int)$_GET['id']);

        include 'views/template/header.php';
        include 'views/admin/detail_produk.php';
        include 'views/template/footer.php';
    }

    public function delete()
    {
        if (isset($_GET['id'])) {
            require_once 'models/Produk.php';
            $produkModel = new Produk();
            $produkModel->delete((int)$_GET['id']);
        }

        header('Location: index.php?c=AdminController&m=dashboard');
        exit;
    }

    public function produk()
    {
        require_once 'models/Produk.php';
        $produkModel = new Produk();
        $data = $produkModel->getAll();

        include 'views/template/header.php';
        include 'views/admin/produk.php';
        include 'views/template/footer.php';
    }
}
