<div class="container mt-4">
  <h3 class="mb-4"><i class="fas fa-clipboard-list text-primary me-2"></i>Kelola Transaksi</h3>

  <div class="mb-3">
    <input type="text" id="search-transaksi" class="form-control" placeholder="🔍 Cari transaksi berdasarkan nama atau status...">
  </div>

  <?php if (empty($data)): ?>
    <div class="alert alert-warning">Belum ada transaksi.</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-bordered align-middle table-hover animate__animated animate__fadeIn">
        <thead class="table-dark">
          <tr>
            <th>No</th>
            <th>Trx ID</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Total</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="tabel-transaksi">
          <!-- Akan dirender via JS -->
        </tbody>
      </table>
    </div>

    <nav>
      <ul class="pagination justify-content-center mt-4" id="pagination"></ul>
    </nav>
  <?php endif; ?>
</div>

<script>
  const data = <?= json_encode($data) ?>;
  let filtered = [...data];
  const perPage = 5;
  let currentPage = 1;

  function renderTable(page = 1) {
    const start = (page - 1) * perPage;
    const end = start + perPage;
    const show = filtered.slice(start, end);
    const body = document.getElementById('tabel-transaksi');
    body.innerHTML = '';

    if (show.length === 0) {
      body.innerHTML = '<tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>';
      return;
    }

    show.forEach((row, index) => {
      const nomor = (currentPage - 1) * perPage + index + 1;
      const badge = row.status === 'paid' ? 'success' :
                    row.status === 'pending' ? 'warning' :
                    row.status === 'failed' ? 'danger' : 'secondary';

      const html = `
        <tr>
          <td>${nomor}</td>
          <td>${row.idtransaksi}</td>
          <td>${row.nama}</td>
          <td>${row.alamat}</td>
          <td>Rp${parseInt(row.total).toLocaleString()}</td>
          <td><span class="badge bg-${badge}">${row.status.toUpperCase()}</span></td>
          <td>${row.created_at}</td>
          <td>
            <a href="index.php?c=TransaksiController&m=invoice&id=${row.idtransaksi}" class="btn btn-sm btn-outline-info">
              <i class="fas fa-file-invoice"></i> Invoice
            </a>
          </td>
        </tr>
      `;
      body.innerHTML += html;
    });

    renderPagination();
  }

  function renderPagination() {
    const total = Math.ceil(filtered.length / perPage);
    const pagination = document.getElementById("pagination");
    pagination.innerHTML = '';

    for (let i = 1; i <= total; i++) {
      const li = document.createElement('li');
      li.className = `page-item ${i === currentPage ? 'active' : ''}`;
      li.innerHTML = `<button class="page-link" onclick="goTo(${i})">${i}</button>`;
      pagination.appendChild(li);
    }
  }

  function goTo(page) {
    currentPage = page;
    renderTable(page);
  }

  document.getElementById("search-transaksi").addEventListener("input", function () {
    const q = this.value.toLowerCase();
    filtered = data.filter(d =>
      d.nama.toLowerCase().includes(q) ||
      d.status.toLowerCase().includes(q) ||
      d.alamat.toLowerCase().includes(q)
    );
    currentPage = 1;
    renderTable(1);
  });

  renderTable(1);
</script>
