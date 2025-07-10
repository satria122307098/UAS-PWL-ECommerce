<h2>Keranjang Belanja</h2>

<?php if (empty($_SESSION['cart'])): ?>
    <div class="alert alert-warning">Keranjang kosong. <a href="index.php?c=ProdukController&m=index">Lihat produk</a></div>
<?php else: ?>
    <div class="mb-3">
        <input type="text" id="cari-keranjang" class="form-control" placeholder="Cari produk di keranjang...">
    </div>

    <div id="hasil-keranjang">
        <!-- Diisi dengan AJAX -->
    </div>

    <script>
        function tampilkanKeranjang(keyword = '') {
            fetch(`index.php?c=CartController&m=searchAjax&q=${encodeURIComponent(keyword)}`)
                .then(res => res.json())
                .then(data => {
                    let html = `
                        <table class="table table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Gambar</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                    `;
                    let total = 0;
                    data.forEach((item, i) => {
                        total += item.subtotal;
                        html += `
                            <tr>
                                <td>${i + 1}</td>
                                <td><img src="assets/img/${item.gambar}" width="60" class="img-thumbnail"></td>
                                <td>${item.nama}</td>
                                <td>Rp${parseInt(item.harga).toLocaleString()}</td>
                                <td>${item.qty}</td>
                                <td>Rp${parseInt(item.subtotal).toLocaleString()}</td>
                                <td>
                                    <a href="index.php?c=CartController&m=delete&id=${item.id}" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        `;
                    });
                    html += `
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5" class="text-end">Total</th>
                                <th colspan="2">Rp${total.toLocaleString()}</th>
                            </tr>
                        </tfoot>
                        </table>

                        <div class="d-flex justify-content-between">
                            <a href="index.php?c=CartController&m=clear" class="btn btn-outline-danger" onclick="return confirm('Kosongkan keranjang?')">
                                <i class="fa fa-trash-alt"></i> Kosongkan
                            </a>
                            <a href="index.php?c=CheckoutController&m=index" class="btn btn-success">
                                <i class="fa fa-credit-card"></i> Checkout
                            </a>
                        </div>
                    `;

                    document.getElementById("hasil-keranjang").innerHTML = html;
                });
        }

        // Load pertama kali
        tampilkanKeranjang();

        // Live search
        document.getElementById("cari-keranjang").addEventListener("input", function () {
            tampilkanKeranjang(this.value);
        });
    </script>
<?php endif; ?>
