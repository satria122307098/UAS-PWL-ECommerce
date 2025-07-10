<h2 class="mb-4">Detail Produk</h2>

<div class="card mb-4 shadow-sm">
  <div class="row g-0">
    <div class="col-md-5 text-center p-3">
      <?php if (!empty($produk['gambar'])): ?>
        <img src="assets/img/<?= htmlspecialchars($produk['gambar']) ?>" 
             class="img-fluid img-zoom" style="max-height: 300px;">
      <?php endif; ?>
    </div>
    <div class="col-md-7">
      <div class="card-body">
        <h4 class="card-title"><?= htmlspecialchars($produk['nama']) ?></h4>
        <p class="text-muted mb-1"><strong>Kategori:</strong> <?= htmlspecialchars($produk['kategori']) ?></p>
        <p class="mb-1"><strong>Harga:</strong> Rp<?= number_format($produk['harga'], 0, ',', '.') ?></p>
        <p class="mb-1"><strong>Berat:</strong> <?= htmlspecialchars($produk['berat']) ?> gr</p>
        <p class="mb-1"><strong>Short Desc:</strong> <?= htmlspecialchars($produk['shortdesc']) ?></p>
        <p class="mt-3"><strong>Deskripsi:</strong><br><?= nl2br(htmlspecialchars($produk['deskripsi'])) ?></p>

        <div class="mt-4 d-flex gap-2">
          <a href="index.php?c=ProdukController&m=index" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
          </a>

          <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
            <a href="index.php?c=AdminController&m=edit&id=<?= $produk['idproduk'] ?>" class="btn btn-warning">
              <i class="fas fa-pen"></i> Edit
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
