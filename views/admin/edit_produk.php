<h2>Edit Produk</h2>
<form action="index.php?c=AdminController&m=update" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $produk['idproduk'] ?>">
    <?php include 'views/admin/form_produk_fields.php'; ?>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
