<h2>Riwayat Transaksi</h2>

<?php if (empty($data)): ?>
    <div class="alert alert-warning">Belum ada transaksi.</div>
<?php else: ?>
    <div class="mb-3">
        <input type="text" id="cari-transaksi" class="form-control" placeholder="Cari transaksi (id, status, produk)...">
    </div>

    <div id="list-transaksi">
        <!-- Transaksi akan dirender oleh JS -->
    </div>

    <nav>
      <ul class="pagination justify-content-center mt-4" id="pagination"></ul>
    </nav>

    <script>
    const dataTransaksi = <?= json_encode($data) ?>;
    let filteredData = [...dataTransaksi];
    const itemsPerPage = 5;
    let currentPage = 1;

    function renderTablePage(page = 1) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const items = filteredData.slice(start, end);
        const container = document.getElementById("list-transaksi");
        let html = '';

        if (items.length === 0) {
            html = '<div class="alert alert-info">Data tidak ditemukan.</div>';
        }

        items.forEach(trx => {
            const badge = trx.status === 'paid' ? 'success' :
                          trx.status === 'failed' ? 'danger' : 'warning';

            html += `
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-1">#${trx.idtransaksi} - ${trx.nama}</h5>
                    <span class="badge bg-${badge} mb-2">${trx.status.toUpperCase()}</span><br>
                    <small class="text-muted">${trx.created_at}</small>
                    <p class="mt-3 mb-1"><strong>Alamat:</strong> ${trx.alamat}</p>
                    <p><strong>Total:</strong> Rp${parseInt(trx.total).toLocaleString()}</p>

                    <h6 class="mt-3">📦 Produk:</h6>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr><th>Produk</th><th>Harga</th><th>Qty</th><th>Subtotal</th></tr>
                        </thead>
                        <tbody>
            `;

            trx.detail.forEach(item => {
                html += `
                    <tr>
                        <td>${item.nama_produk}</td>
                        <td>Rp${parseInt(item.harga).toLocaleString()}</td>
                        <td>${item.qty}</td>
                        <td>Rp${parseInt(item.subtotal).toLocaleString()}</td>
                    </tr>
                `;
            });

            html += `
                        </tbody>
                    </table>
                </div>
            </div>`;
        });

        container.innerHTML = html;
        renderPagination();
    }

    function renderPagination() {
        const totalPages = Math.ceil(filteredData.length / itemsPerPage);
        const pagination = document.getElementById("pagination");
        let html = '';

        for (let i = 1; i <= totalPages; i++) {
            html += `
              <li class="page-item ${i === currentPage ? 'active' : ''}">
                <button class="page-link" onclick="goToPage(${i})">${i}</button>
              </li>`;
        }

        pagination.innerHTML = html;
    }

    function goToPage(page) {
        currentPage = page;
        renderTablePage(page);
    }

    document.getElementById("cari-transaksi").addEventListener("input", function () {
        const keyword = this.value.toLowerCase();
        filteredData = dataTransaksi.filter(trx => {
            const produk = trx.detail.map(p => p.nama_produk.toLowerCase()).join(" ");
            return (
                trx.idtransaksi.toString().includes(keyword) ||
                trx.status.toLowerCase().includes(keyword) ||
                produk.includes(keyword)
            );
        });
        currentPage = 1;
        renderTablePage(1);
    });

    // Init first render
    renderTablePage(1);
    </script>
<?php endif; ?>
