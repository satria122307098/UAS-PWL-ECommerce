<h2>Checkout</h2>

<form action="index.php?c=CheckoutController&m=process" method="POST">
    <div class="mb-3">
        <label>Nama Penerima</label>
        <input type="text" name="nama" class="form-control" required value="<?= $_SESSION['user']['nama'] ?? '' ?>">
    </div>
    <div class="mb-3">
        <label>Alamat Pengiriman</label>
        <textarea name="alamat" class="form-control" required></textarea>
    </div>
    <button type="submit" class="btn btn-success">
        <i class="fa fa-credit-card"></i> Lanjutkan Pembayaran
    </button>
</form>
