<?php

class ProdukController
{
    public function index()
    {
        require_once 'models/Produk.php';
        $produkModel = new Produk();
        $data = $produkModel->getAll();

        include 'views/template/header.php';
        include 'views/produk/index.php';
        include 'views/template/footer.php';
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
        include 'views/produk/detail.php';
        include 'views/template/footer.php';
    }

    public function searchAjax()
    {
        if (isset($_GET['q'])) {
            require_once 'models/Produk.php';
            $produkModel = new Produk();
            $keyword = trim($_GET['q']);
            $data = $produkModel->searchByKeyword($keyword);
            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    public function apiGetProduk()
    {
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing ID']);
            return;
        }

        require_once 'models/Produk.php';
        $produkModel = new Produk();
        $produk = $produkModel->getById((int)$_GET['id']);

        header('Content-Type: application/json');
        echo json_encode($produk);
    }



}
