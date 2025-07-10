<h2 class="mb-4">Daftar Produk</h2>

<div class="mb-3">
    <input type="text" id="cari-produk" class="form-control" placeholder="Cari produk...">
</div>

<div class="row" id="hasil-produk"></div>

<nav>
  <ul class="pagination justify-content-center mt-4" id="produk-pagination"></ul>
</nav>

<!-- Modal -->
<div class="modal fade" id="modalBeli" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="index.php?c=CartController&m=add">
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Tambah ke Keranjang</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="text-center mb-3">
              <img id="modalGambar" src="" class="img-fluid rounded" style="max-height:200px;">
          </div>
          <h5 id="modalNama"></h5>
          <p class="text-muted" id="modalHarga"></p>

          <input type="hidden" name="idproduk" id="modalIdProduk">
          <div class="input-group">
            <button type="button" class="btn btn-outline-secondary" id="btnMinus">−</button>
            <input type="number" class="form-control text-center" name="qty" id="modalQty" value="1" min="1">
            <button type="button" class="btn btn-outline-secondary" id="btnPlus">+</button>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">
            <i class="fa fa-cart-plus"></i> Tambahkan ke Keranjang
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<style>
.card-img-hover {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  cursor: pointer;
}
.card-img-hover:hover {
  transform: scale(1.05);
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
</style>

<script>
const allProduk = <?= json_encode($data) ?>;
let filteredProduk = [...allProduk];
const perPage = 6;
let currentPage = 1;

function renderProduk(page = 1) {
  const start = (page - 1) * perPage;
  const end = start + perPage;
  const tampil = filteredProduk.slice(start, end);

  let html = '';
  if (tampil.length === 0) {
    html = `<div class="col-12"><div class="alert alert-warning">Produk tidak ditemukan.</div></div>`;
  } else {
    tampil.forEach(p => {
      html += `
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
          <a href="index.php?c=ProdukController&m=detail&id=${p.idproduk}">
              <img src="assets/img/${p.gambar}" class="card-img-top card-img-hover" style="height: 200px; object-fit: cover;">
            </a>

          <div class="card-body d-flex flex-column">
            <h5 class="card-title">${p.nama}</h5>
            <p class="card-text text-muted">${p.shortdesc}</p>
            <p class="card-text fw-bold">Rp${parseInt(p.harga).toLocaleString()}</p>
            <div class="mt-auto">
              <a href="index.php?c=ProdukController&m=detail&id=${p.idproduk}" class="btn btn-primary mb-2 w-100">
                <i class="fa fa-eye"></i> Detail
              </a>
              ${<?= isset($_SESSION['user']) && $_SESSION['user']['role'] === 'user' ? 'true' : 'false' ?> ?
                `<button class="btn btn-success w-100 btn-beli" data-id="${p.idproduk}">
                  <i class="fa fa-cart-plus"></i> Beli
                </button>` :
                `<a href="index.php?c=UserController&m=login" class="btn btn-outline-primary w-100">
                  <i class="fa fa-sign-in-alt"></i> Login untuk Beli
                </a>`}
            </div>
          </div>
        </div>
      </div>`;
    });
  }

  document.getElementById("hasil-produk").innerHTML = html;
  renderPagination();
}

function renderPagination() {
  const totalPages = Math.ceil(filteredProduk.length / perPage);
  const pagination = document.getElementById("produk-pagination");
  pagination.innerHTML = '';

  for (let i = 1; i <= totalPages; i++) {
    pagination.innerHTML += `
      <li class="page-item ${i === currentPage ? 'active' : ''}">
        <button class="page-link" onclick="goToPage(${i})">${i}</button>
      </li>`;
  }
}

function goToPage(page) {
  currentPage = page;
  renderProduk(page);
}

document.getElementById("cari-produk").addEventListener("input", function () {
  const q = this.value.toLowerCase();
  filteredProduk = allProduk.filter(p =>
    p.nama.toLowerCase().includes(q) ||
    (p.kategori || '').toLowerCase().includes(q) ||
    (p.shortdesc || '').toLowerCase().includes(q)
  );
  currentPage = 1;
  renderProduk(currentPage);
});

document.addEventListener("click", function(e) {
  if (e.target.classList.contains("btn-beli")) {
    const id = e.target.dataset.id;
    fetch(`index.php?c=ProdukController&m=apiGetProduk&id=${id}`)
      .then(res => res.json())
      .then(p => {
        document.getElementById("modalNama").textContent = p.nama;
        document.getElementById("modalHarga").textContent = `Rp${parseInt(p.harga).toLocaleString()}`;
        document.getElementById("modalGambar").src = "assets/img/" + p.gambar;
        document.getElementById("modalIdProduk").value = id;
        document.getElementById("modalQty").value = 1;
        new bootstrap.Modal(document.getElementById('modalBeli')).show();
      });
  }
});

document.getElementById("btnPlus").onclick = () => {
  let qty = parseInt(document.getElementById("modalQty").value);
  document.getElementById("modalQty").value = qty + 1;
};
document.getElementById("btnMinus").onclick = () => {
  let qty = parseInt(document.getElementById("modalQty").value);
  if (qty > 1) document.getElementById("modalQty").value = qty - 1;
};

// Init
renderProduk(1);
</script>
