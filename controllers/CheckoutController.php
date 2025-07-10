<?php

class CheckoutController
{
    public function index()
    {
        if (!isset($_SESSION['user']) || empty($_SESSION['cart'])) {
            header('Location: index.php?c=ProdukController&m=index');
            exit;
        }

        include 'views/template/header.php';
        include 'views/checkout/index.php';
        include 'views/template/footer.php';
    }

    public function process()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once 'vendor/autoload.php';
            require_once 'models/Checkout.php';
            require_once __DIR__ . '/../config.php';
            $nama   = trim($_POST['nama']);
            $alamat = trim($_POST['alamat']);
            $iduser = $_SESSION['user']['iduser'];
            $cart   = $_SESSION['cart'];
            $total  = 0;

            foreach ($cart as $item) {
                $total += $item['qty'] * $item['harga'];
            }

            $checkout = new Checkout();

            // 1. Simpan transaksi ke database terlebih dahulu
            $idtransaksi = $checkout->simpanTransaksi($iduser, $nama, $alamat, $total, '-', $cart);

            // 2. Konfigurasi Midtrans tidak dipakai lagi, krn sudah dipindah ke config.php
           /* \Midtrans\Config::$serverKey = 'SB-Mid-xxxxxxxxxxxxxxxxxxxxx';
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true; */

            $transaction_details = [
                'order_id' => $idtransaksi,
                'gross_amount' => $total
            ];

            $item_details = [];
            foreach ($cart as $id => $item) {
                $item_details[] = [
                    'id' => $id,
                    'price' => $item['harga'],
                    'quantity' => $item['qty'],
                    'name' => $item['nama']
                ];
            }

            $customer_details = [
                'first_name' => $nama,
                'address' => $alamat
            ];

            $params = [
                'transaction_details' => $transaction_details,
                'item_details' => $item_details,
                'customer_details' => $customer_details
            ];

            // 3. Ambil Snap Token dari Midtrans
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // 4. Update token ke database
            $checkout->updateSnapToken($idtransaksi, $snapToken);

            // 5. Kosongkan keranjang
            $_SESSION['cart'] = [];
            $_SESSION['snap_token'] = $snapToken;

            // 6. Redirect ke halaman bayar
            header("Location: index.php?c=CheckoutController&m=bayar&id=$idtransaksi");
            exit;
        }
    }

    public function bayar()
    {
        if (!isset($_GET['id']) || !isset($_SESSION['snap_token'])) {
            header('Location: index.php');
            exit;
        }

        $snapToken = $_SESSION['snap_token'];

        include 'views/template/header.php';
        include 'views/checkout/bayar.php';
        include 'views/template/footer.php';
    }
}
