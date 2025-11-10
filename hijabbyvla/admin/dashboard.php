<?php
session_start();
require_once("../config.php");
if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../public/login.html");
    exit;
}

// Ambil total pesanan
$totalPesanan = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$pesanan = $pdo->query("SELECT id, customer_name, total, status, created_at FROM orders ORDER BY created_at DESC LIMIT 10")->fetchAll();

// Ambil total produk
$totalProduk = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$produk = $pdo->query("SELECT * FROM products ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin - Hijabbyvla</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #fafafa; }
    .brand-gradient { background: linear-gradient(90deg,#e91e63,#9c27b0); }
    .btn-brand {
      background: linear-gradient(90deg,#e91e63,#9c27b0);
      border: none;
      color: #fff;
    }
    .btn-brand:hover { opacity: .9; color: #fff; }
    .card { border: none; border-radius: 12px; }
    .card-header { font-weight: 600; }
    .navbar-brand span { color: #3f1825ff; }
    img.thumb { max-width: 70px; border-radius: 8px; }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark brand-gradient shadow-sm">
    <div class="container-fluid px-4">
      <a class="navbar-brand fw-bold" href="#">Admin <span>HijabByVLA</span></a>
      <div class="d-flex">
        <a href="../api/logout.php" class="btn btn-light btn-sm">Logout</a>
      </div>
    </div>
  </nav>

  <div class="container my-4">
    <h2 class="mb-4 fw-bold">Dashboard Admin</h2>

    <!-- Ringkasan -->
    <div class="row g-4 mb-4">
      <div class="col-md-6">
        <div class="card text-center shadow-sm">
          <div class="card-body">
            <h6 class="text-muted">Total Pesanan</h6>
            <h2 class="fw-bold text-primary"><?= $totalPesanan ?></h2>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card text-center shadow-sm">
          <div class="card-body">
            <h6 class="text-muted">Total Produk</h6>
            <h2 class="fw-bold text-success"><?= $totalProduk ?></h2>
          </div>
        </div>
      </div>
    </div>

    <!-- Rekap Pesanan -->
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-white">Rekap Pesanan Terbaru</div>
      <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Nama Customer</th>
              <th>Total</th>
              <th>Status</th>
              <th>Tanggal</th>
              <th>Aksi</th> <!-- Tambahan kolom -->
            </tr>
          </thead>
          <tbody>
            <?php if (count($pesanan) > 0): ?>
              <?php foreach ($pesanan as $p): ?>
              <tr>
                <td><?= $p['id'] ?></td>
                <td><?= htmlspecialchars($p['customer_name']) ?></td>
                <td>Rp<?= number_format($p['total'],0,',','.') ?></td>
                <td>
                  <span class="badge 
                    <?php if($p['status']=='pending') echo 'bg-warning text-dark'; 
                          elseif($p['status']=='paid') echo 'bg-info'; 
                          elseif($p['status']=='shipped') echo 'bg-primary'; 
                          elseif($p['status']=='completed') echo 'bg-success'; 
                          else echo 'bg-secondary'; ?>">
                    <?= ucfirst($p['status']) ?>
                  </span>
                </td>
                <td><?= $p['created_at'] ?></td>
                <td>
                  <a href="detail_pesanan.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-brand">Detail</a>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="6" class="text-center text-muted">Belum ada pesanan</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Katalog Produk -->
    <div class="card shadow-sm">
      <div class="card-header d-flex justify-content-between align-items-center bg-white">
        <span>Kelola Produk</span>
        <a href="tambah_produk.php" class="btn btn-brand btn-sm">+ Tambah Produk</a>
      </div>
      <div class="card-body p-0">
        <table class="table table-hover table-bordered mb-0 align-middle">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Foto</th>
              <th>Nama</th>
              <th>Deskripsi</th>
              <th>Harga</th>
              <th>Stok</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($produk) > 0): ?>
              <?php foreach ($produk as $pr): ?>
              <tr>
                <td><?= $pr['id'] ?></td>
                <td>
                  <?php if (!empty($pr['image'])): ?>
                    <img src="../<?= $pr['image'] ?>" alt="Produk" class="thumb">
                  <?php else: ?>
                    <span class="text-muted">-</span>
                  <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($pr['name']) ?></td>
                <td><?= htmlspecialchars($pr['description']) ?></td>
                <td>Rp<?= number_format($pr['price'],0,',','.') ?></td>
                <td><?= $pr['stock'] ?></td>
                <td>
                  <a href="edit_produk.php?id=<?= $pr['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                  <a href="hapus_produk.php?id=<?= $pr['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
              </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr><td colspan="7" class="text-center text-muted">Belum ada produk</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <footer class="footer">
    <div class="container">
      <p>© 2025 hijabbyvla. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>
