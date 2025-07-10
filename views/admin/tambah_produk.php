<h2>Tambah Produk</h2>
<form action="index.php?c=AdminController&m=simpan" method="POST" enctype="multipart/form-data">
    <?php include 'views/admin/form_produk_fields.php'; ?>
    <button type="submit" class="btn btn-primary">Simpan</button>
</form>
