<?php include 'views/template/header.php'; ?>

<style>
@media print {
  .btn, .navbar, footer, input, nav {
    display: none !important;
  }

  body {
    background: #fff;
    font-size: 12pt;
  }

  .container {
    margin: 0;
    padding: 0;
    width: 100%;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  th, td {
    border: 1px solid #000;
    padding: 8px;
  }
}
</style>

<div class="container my-4">
  <div class="card shadow-sm animate__animated animate__fadeIn">
    <div class="card-body">
      <h4 class="mb-3">
        <i class="fas fa-file-invoice text-primary me-2"></i>
        Invoice #<?= $data['idtransaksi'] ?>
      </h4>

      <div class="row mb-3">
        <div class="col-md-6">
          <p><strong>Nama:</strong> <?= htmlspecialchars($data['nama']) ?></p>
          <p><strong>Alamat:</strong> <?= htmlspecialchars($data['alamat']) ?></p>
          <p><strong>Status:</strong>
            <span class="badge bg-<?= match($data['status']) {
              'paid' => 'success',
              'pending' => 'warning',
              'failed' => 'danger',
              default => 'secondary'
            } ?>">
              <?= strtoupper($data['status']) ?>
            </span>
          </p>
        </div>
        <div class="col-md-6 text-end">
          <p><strong>Tanggal:</strong> <?= date('d-m-Y H:i', strtotime($data['created_at'])) ?></p>
        </div>
      </div>

      <h6 class="mb-2">📦 Daftar Produk:</h6>
      <div class="table-responsive">
        <table class="table table-bordered table-sm">
          <thead class="table-light">
            <tr>
              <th>Produk</th>
              <th>Harga</th>
              <th>Qty</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php $total = 0; ?>
            <?php foreach ($detail as $item): ?>
              <?php
                $subtotal = $item['harga'] * $item['qty'];
                $total += $subtotal;
              ?>
              <tr>
                <td><?= htmlspecialchars($item['nama_produk']) ?></td>
                <td>Rp<?= number_format($item['harga'], 0, ',', '.') ?></td>
                <td><?= $item['qty'] ?></td>
                <td>Rp<?= number_format($subtotal, 0, ',', '.') ?></td>
              </tr>
            <?php endforeach; ?>
            <tr class="fw-bold">
              <td colspan="3" class="text-end">Total</td>
              <td>Rp<?= number_format($total, 0, ',', '.') ?></td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="mt-4 text-end">
        <a href="index.php?c=<?= $_SESSION['user']['role'] === 'admin' ? 'AdminController&m=transaksi' : 'TransaksiController&m=index' ?>" class="btn btn-secondary">
          <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <button onclick="window.print()" class="btn btn-primary">
          <i class="fas fa-print"></i> Cetak
        </button>
      </div>
    </div>
  </div>
</div>

<?php include 'views/template/footer.php'; ?>
