<div class="mb-3">
    <label>Nama Produk</label>
    <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($produk['nama'] ?? '') ?>" required>
</div>
<div class="mb-3">
    <label>Kategori</label>
    <input type="text" name="kategori" class="form-control" value="<?= htmlspecialchars($produk['kategori'] ?? '') ?>" required>
</div>
<div class="mb-3">
    <label>Short Description</label>
    <input type="text" name="shortdesc" class="form-control" value="<?= htmlspecialchars($produk['shortdesc'] ?? '') ?>" required>
</div>
<div class="mb-3">
    <label>Deskripsi</label>
    <textarea name="deskripsi" class="form-control" required><?= htmlspecialchars($produk['deskripsi'] ?? '') ?></textarea>
</div>
<div class="mb-3">
    <label>Harga (Rp)</label>
    <input type="number" name="harga" class="form-control" value="<?= htmlspecialchars($produk['harga'] ?? '') ?>" required>
</div>
<div class="mb-3">
    <label>Berat (gram)</label>
    <input type="number" name="berat" class="form-control" value="<?= htmlspecialchars($produk['berat'] ?? '') ?>" required>
</div>
<div class="mb-3">
    <label>Gambar Produk</label>
    <input type="file" name="gambar" class="form-control" accept="image/*">
</div>

<?php if (!empty($produk['gambar'])): ?>
    <div class="mb-3">
        <p>Gambar saat ini:</p>
        <img src="assets/img/<?= htmlspecialchars($produk['gambar']) ?>" class="img-fluid rounded" style="max-width: 200px;">
        <input type="hidden" name="gambar_lama" value="<?= htmlspecialchars($produk['gambar']) ?>">
    </div>
<?php endif; ?>


