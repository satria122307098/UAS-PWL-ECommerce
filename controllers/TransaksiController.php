<?php

class TransaksiController
{
    public function index()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
            header('Location: index.php?c=UserController&m=login');
            exit;
        }

        require_once 'models/Checkout.php';
        $checkout = new Checkout();
        $data = $checkout->getTransaksiByUser($_SESSION['user']['iduser']);

        // Ambil detail untuk setiap transaksi
        foreach ($data as $key => $trx) {
            $data[$key]['detail'] = $checkout->getDetailTransaksi($trx['idtransaksi']);
        }

        include 'views/template/header.php';
        include 'views/transaksi/index.php';
        include 'views/template/footer.php';
    }

    public function invoice()
    {
        if (!isset($_SESSION['user']) || !isset($_GET['id'])) {
            echo "Akses tidak sah.";
            exit;
        }

        require_once 'models/Checkout.php';
        $checkout = new Checkout();

        $idtransaksi = (int) $_GET['id'];
        $data = $checkout->getTransaksiById($idtransaksi);
        $detail = $checkout->getDetailTransaksi($idtransaksi);

        // ✅ Izinkan jika user adalah pemilik transaksi ATAU admin
        if (
            !$data ||
            ($_SESSION['user']['role'] !== 'admin' &&
             $data['iduser'] != $_SESSION['user']['iduser'])
        ) {
            echo "Akses tidak sah.";
            exit;
        }

       include 'views/transaksi/invoice.php';

    }


}
