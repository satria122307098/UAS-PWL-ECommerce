<div class="container mt-4">
    <h3 class="mb-4"><i class="fas fa-chart-line me-2 text-primary"></i>Dashboard Admin</h3>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 animate__animated animate__fadeInUp bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-box-open me-2"></i>Total Produk</h5>
                    <h2 class="card-text"><?= $data['produk'] ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 animate__animated animate__fadeInUp bg-secondary text-white">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-users me-2"></i>Total User</h5>
                    <h2 class="card-text"><?= $data['users'] ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 animate__animated animate__fadeInUp bg-dark text-white">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-file-invoice-dollar me-2"></i>Total Transaksi</h5>
                    <h2 class="card-text"><?= $data['transaksi'] ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-2">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 animate__animated animate__fadeInUp bg-success text-white">
                <div class="card-body">
                    <h6><i class="fas fa-check-circle me-2"></i>Paid</h6>
                    <h3><?= $data['transaksi_status']['paid'] ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 animate__animated animate__fadeInUp bg-warning text-dark">
                <div class="card-body">
                    <h6><i class="fas fa-hourglass-half me-2"></i>Pending</h6>
                    <h3><?= $data['transaksi_status']['pending'] ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 animate__animated animate__fadeInUp bg-danger text-white">
                <div class="card-body">
                    <h6><i class="fas fa-times-circle me-2"></i>Failed</h6>
                    <h3><?= $data['transaksi_status']['failed'] ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 animate__animated animate__fadeInUp bg-info text-white">
                <div class="card-body">
                    <h6><i class="fas fa-coins me-2"></i>Total Pemasukan</h6>
                    <h4>Rp<?= number_format($data['transaksi_status']['pemasukan'], 0, ',', '.') ?></h4>
                </div>
            </div>
        </div>
    </div>
</div>
