<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>UASEcommerce</title>

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <!-- Sticky Footer Layout -->
  <style>
    html, body {
      height: 100%;
    }
    body {
      display: flex;
      flex-direction: column;
    }
    .content-wrapper {
      flex: 1;
    }
    .btn:hover {
      transform: scale(1.02);
      transition: all 0.2s ease-in-out;
    }
    .card-img-hover {
      transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
      cursor: pointer;
    }

    .card-img-hover:hover {
      transform: scale(1.05);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }
    .img-zoom {
      transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
      border-radius: 0.5rem;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .img-zoom:hover {
      transform: scale(1.05);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }


  </style>
</head>
<body class="bg-light animate__animated animate__fadeIn">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="index.php">UASEcommerce</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <?php if (!isset($_SESSION['user'])): ?>
          <li class="nav-item"><a class="nav-link" href="index.php?c=UserController&m=login"><i class="fas fa-sign-in-alt"></i> Login</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php?c=UserController&m=register"><i class="fas fa-user-plus"></i> Daftar</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="#">👋 <?= htmlspecialchars($_SESSION['user']['nama']) ?></a></li>

          <?php if ($_SESSION['user']['role'] === 'user'): ?>
            <li class="nav-item"><a class="nav-link" href="index.php?c=ProdukController&m=index"><i class="fas fa-store"></i> Produk</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php?c=CartController&m=index"><i class="fas fa-shopping-cart"></i> Keranjang</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php?c=TransaksiController&m=index"><i class="fas fa-receipt"></i> Riwayat</a></li>
          <?php endif; ?>

          <?php if ($_SESSION['user']['role'] === 'admin'): ?>

            <li class="nav-item">
              <a class="nav-link" href="index.php?c=AdminController&m=produk">
                <i class="fas fa-boxes"></i> Kelola Produk
              </a>
            </li>

            <li class="nav-item"><a class="nav-link" href="index.php?c=AdminController&m=dashboard"><i class="fas fa-tools"></i> Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="index.php?c=AdminController&m=transaksi"><i class="fas fa-clipboard-list"></i> Transaksi</a></li>
          <?php endif; ?>

          <li class="nav-item"><a class="nav-link" href="index.php?c=UserController&m=logout"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Konten mulai -->
<div class="container content-wrapper mt-4">
