<?php

class CartController
{
    public function __construct()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
            header('Location: index.php?c=UserController&m=login');
            exit;
        }
    }

   public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idproduk = (int)$_POST['idproduk'];
            $qty = max(1, (int)$_POST['qty']);

            require_once 'models/Produk.php';
            $produkModel = new Produk();
            $produk = $produkModel->getById($idproduk);

            if (!$produk) {
                header('Location: index.php?c=ProdukController&m=index');
                exit;
            }

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            if (isset($_SESSION['cart'][$idproduk])) {
                $_SESSION['cart'][$idproduk]['qty'] += $qty;
            } else {
                $_SESSION['cart'][$idproduk] = [
                    'nama' => $produk['nama'],
                    'harga' => $produk['harga'],
                    'gambar' => $produk['gambar'],
                    'qty' => $qty
                ];
            }

            header('Location: index.php?c=CartController&m=index');
            exit;
        }

        // Optional: fallback untuk GET (beli 1 unit langsung)
        if (isset($_GET['id'])) {
            $_POST['idproduk'] = $_GET['id'];
            $_POST['qty'] = 1;
            $this->add(); // rekursif
        }
    }


    public function index()
    {
        include 'views/template/header.php';
        include 'views/cart/index.php';
        include 'views/template/footer.php';
    }

    public function delete()
    {
        if (isset($_GET['id']) && isset($_SESSION['cart'][$_GET['id']])) {
            unset($_SESSION['cart'][$_GET['id']]);
        }

        header('Location: index.php?c=CartController&m=index');
        exit;
    }

    public function clear()
    {
        unset($_SESSION['cart']);
        header('Location: index.php?c=CartController&m=index');
        exit;
    }

    public function searchAjax()
    {
        $hasil = [];

        if (isset($_SESSION['cart'])) {
            $keyword = isset($_GET['q']) ? strtolower($_GET['q']) : '';

            foreach ($_SESSION['cart'] as $id => $item) {
                if (stripos($item['nama'], $keyword) !== false) {
                    $hasil[] = [
                        'id' => $id,
                        'nama' => $item['nama'],
                        'harga' => $item['harga'],
                        'qty' => $item['qty'],
                        'gambar' => $item['gambar'],
                        'subtotal' => $item['qty'] * $item['harga']
                    ];
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($hasil);
    }

}
