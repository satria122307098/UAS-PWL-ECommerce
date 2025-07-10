<h2>Proses Pembayaran</h2>

<p>Silakan selesaikan pembayaran Anda di jendela Midtrans Snap yang muncul.</p>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-Q6gt2owO5zIKrmbn"></script>
<script>
    snap.pay("<?= $_SESSION['snap_token'] ?>", {
        onSuccess: function(result){
            alert("Pembayaran berhasil!");
            window.location.href = "index.php?c=TransaksiController&m=index";
        },
        onPending: function(result){
            alert("Transaksi sedang diproses.");
            window.location.href = "index.php?c=TransaksiController&m=index";
        },
        onError: function(result){
            alert("Terjadi kesalahan pembayaran.");
            window.location.href = "index.php";
        }
    });
</script>
