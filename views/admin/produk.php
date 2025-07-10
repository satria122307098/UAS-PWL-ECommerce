<div class="container mt-4">
  <h3 class="mb-4"><i class="fas fa-boxes text-primary me-2"></i>Kelola Produk</h3>

  <a href="index.php?c=AdminController&m=tambah" class="btn btn-primary mb-3">
    <i class="fas fa-plus-circle"></i> Tambah Produk
  </a>

  <div class="mb-3">
    <input type="text" id="search-produk" class="form-control" placeholder="🔍 Cari produk (nama, kategori)...">
  </div>

  <?php if (empty($data)): ?>
    <div class="alert alert-warning">Belum ada produk.</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-bordered align-middle table-hover">
        <thead class="table-dark">
          <tr>
            <th>Gambar</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Berat</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody id="produk-tbody">
          <!-- Render isi produk lewat JS -->
        </tbody>
      </table>
    </div>

    <nav>
      <ul class="pagination justify-content-center mt-4" id="produk-pagination"></ul>
    </nav>
  <?php endif; ?>
</div>

<script>
  const semuaProduk = <?= json_encode($data) ?>;
  let filteredProduk = [...semuaProduk];
  const perPage = 5;
  let currentPage = 1;

  function renderProduk(page = 1) {
    const start = (page - 1) * perPage;
    const end = start + perPage;
    const tampil = filteredProduk.slice(start, end);
    const tbody = document.getElementById("produk-tbody");
    tbody.innerHTML = "";

    if (tampil.length === 0) {
      tbody.innerHTML = `<tr><td colspan="6" class="text-center text-muted">Produk tidak ditemukan.</td></tr>`;
      return;
    }

    tampil.forEach(row => {
      const gambar = row.gambar
        ? `<img src="assets/img/${row.gambar}" class="img-fluid rounded" style="max-height: 60px;">`
        : '<span class="text-muted">-</span>';

      tbody.innerHTML += `
        <tr>
          <td style="max-width:100px;">${gambar}</td>
          <td>${row.nama}</td>
          <td>${row.kategori}</td>
          <td>Rp${parseInt(row.harga).toLocaleString()}</td>
          <td>${row.berat} gr</td>
          <td>
            <a href="index.php?c=AdminController&m=detail&id=${row.idproduk}" class="btn btn-sm btn-info">
              <i class="fas fa-eye"></i>
            </a>
            <a href="index.php?c=AdminController&m=edit&id=${row.idproduk}" class="btn btn-sm btn-warning">
              <i class="fas fa-edit"></i>
            </a>
            <a href="index.php?c=AdminController&m=delete&id=${row.idproduk}" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus produk ini?')">
              <i class="fas fa-trash"></i>
            </a>
          </td>
        </tr>`;
    });

    renderPagination();
  }

  function renderPagination() {
    const totalPages = Math.ceil(filteredProduk.length / perPage);
    const pagination = document.getElementById("produk-pagination");
    pagination.innerHTML = "";

    for (let i = 1; i <= totalPages; i++) {
      const li = document.createElement("li");
      li.className = `page-item ${i === currentPage ? 'active' : ''}`;
      li.innerHTML = `<button class="page-link" onclick="goTo(${i})">${i}</button>`;
      pagination.appendChild(li);
    }
  }

  function goTo(page) {
    currentPage = page;
    renderProduk(page);
  }

  document.getElementById("search-produk").addEventListener("input", function () {
    const q = this.value.toLowerCase();
    filteredProduk = semuaProduk.filter(p =>
      p.nama.toLowerCase().includes(q) ||
      p.kategori.toLowerCase().includes(q)
    );
    currentPage = 1;
    renderProduk(1);
  });

  renderProduk(1);
</script>
