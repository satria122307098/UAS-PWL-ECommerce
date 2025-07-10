<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config.php';

\Midtrans\Config::$serverKey = 'SB-xxxxxxxxxxxxxxxxxxxxx';
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

// Ambil JSON callback dari Midtrans
$json = file_get_contents('php://input');

// Simpan isi mentah log ke file
file_put_contents(__DIR__ . "/callback-debug.txt", date('Y-m-d H:i:s') . "\nRAW JSON:\n" . var_export($json, true) . "\n\n", FILE_APPEND);

$data = json_decode($json);

// Validasi isi data
if (!isset($data->order_id) || !isset($data->transaction_status)) {
    http_response_code(400);
    exit('Invalid payload');
}

$orderId = (int) $data->order_id;
$midtransStatus = strtolower($data->transaction_status);

// Konversi status Midtrans ke status lokal
$convertedStatus = match ($midtransStatus) {
    'settlement', 'capture', 'success' => 'paid',
    'expire', 'deny', 'cancel'         => 'failed',
    default                            => 'pending'
};

// Update status ke database
$stmt = $mysqli->prepare("UPDATE transaksi SET status = ? WHERE idtransaksi = ?");
$stmt->bind_param("si", $convertedStatus, $orderId);
$stmt->execute();

// Tambahkan log status update
file_put_contents(__DIR__ . "/callback-result.txt", "Status update: $convertedStatus untuk ID: $orderId\n", FILE_APPEND);

// Kirim respon OK ke Midtrans
http_response_code(200);
echo 'OK';
