<?php
    require_once 'vendor/autoload.php';
    \Midtrans\Config::$serverKey = 'SB-xxxxxxxxxxxxxxx';
    \Midtrans\Config::$clientKey = 'SB-xxxxxxxxxxxxxxxxx';
    \Midtrans\Config::$isProduction = false;
    \Midtrans\Config::$isSanitized = true;
   \Midtrans\Config::$is3ds = true;


    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db   = 'UASEcommerce';

    // Membuat koneksi
    $mysqli = new mysqli($host, $user, $pass, $db);

    // Periksa koneksi
    if ($mysqli->connect_error) {
        die("Koneksi database gagal: " . $mysqli->connect_error);
    }

    
?>
