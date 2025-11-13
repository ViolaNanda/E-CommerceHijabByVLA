<?php
session_start();
require_once("../config.php");

// Ambil kata kunci pencarian (kalau ada)
$keyword = isset($_GET['search']) ? trim($_GET['search']) : '';

// Query produk (dengan atau tanpa pencarian)
if ($keyword) {
  $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE ? ORDER BY created_at DESC");
  $stmt->execute(['%' . $keyword . '%']);
  $produk = $stmt->fetchAll();
} else {
  $produk = $pdo->query("SELECT * FROM products ORDER BY created_at DESC")->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Katalog - HijabByVla</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    /* Header */
    .page-header {
      text-align: center;
      padding: 40px 20px;
      background: linear-gradient(90deg, #e91e63, #9c27b0);
      color: #fff;
      border-radius: 0 0 20px 20px;
      margin-bottom: 30px;
    }
    .page-header h1 {
      font-size: 32px;
      font-weight: bold;
      margin-bottom: 10px;
    }
    .page-header p {
      font-size: 16px;
      opacity: 0.9;
    }

    /* Produk */
    .produk-list {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 20px;
    }
    .card {
      background: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 16px rgba(0,0,0,0.15);
    }
    .card img {
      width: 100%;
      height: 220px;
      object-fit: cover;
    }
    .card-body {
      padding: 15px;
      text-align: center;
    }
    .card-body h3 {
      font-size: 18px;
      margin-bottom: 8px;
      color: #333;
    }
    .card-body .price {
      font-size: 16px;
      font-weight: bold;
      color: #e91e63;
      margin-bottom: 10px;
    }
    .btn.btn-primary {
      display: inline-block;
      padding: 8px 15px;
      border: none;
      border-radius: 8px;
      background: linear-gradient(90deg,#e91e63,#9c27b0);
      color: #fff;
      cursor: pointer;
      transition: opacity 0.2s;
      text-decoration: none;
      position: relative;
      z-index: 1001; /* pastikan di atas notifikasi */
    }
    .btn.btn-primary:hover {
      opacity: 0.9;
    }

    /* Navbar */
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #fff;
      padding: 15px 40px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      margin-bottom: 20px;
      position: relative;
      z-index: 1000;
    }
    .navbar .logo {
      font-size: 24px;
      font-weight: bold;
      color: #e91e63;
    }
    .navbar .logo span {
      color: #9c27b0;
    }
    .nav-links {
      list-style: none;
      display: flex;
      gap: 20px;
    }
    .nav-links a {
      text-decoration: none;
      color: #333;
      font-weight: 500;
    }
    .nav-links a.active {
      color: #e91e63;
    }
    .nav-right {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .search {
      padding: 8px 12px;
      border-radius: 8px;
      border: 1px solid #ddd;
    }

    /* Notifikasi sukses */
    .notif {
      position: fixed;
      top: 20px;
      right: 20px;
      background: #4caf50;
      color: #fff;
      padding: 12px 20px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      z-index: 9999;
      animation: fadeOut 3s forwards;
      font-size: 15px;
      pointer-events: none; /* biar tidak menghalangi klik */
    }
    @keyframes fadeOut {
      0% { opacity: 1; }
      80% { opacity: 1; }
      100% { opacity: 0; transform: translateY(-20px); }
    }
  </style>
</head>
<body>

  <!-- Notifikasi Sukses -->
  <?php if (isset($_SESSION['success_message'])): ?>
    <div class="notif">
      <?= $_SESSION['success_message']; ?>
    </div>
    <?php unset($_SESSION['success_message']); ?>
  <?php endif; ?>

  <!-- Navbar -->
  <nav class="navbar">
    <div class="logo">HijabBy<span>VLA</span></div>
    <ul class="nav-links">
      <li><a href="index.php">Beranda</a></li>
      <li><a href="katalog.php" class="active">Katalog</a></li>
      <li><a href="tentang.php">Tentang</a></li>
      <li><a href="promo.php">Promo</a></li>
    </ul>
    <div class="nav-right">
      <!-- Form pencarian -->
      <form action="katalog.php" method="GET" style="display:inline;">
        <input 
          type="text" 
          name="search" 
          class="search" 
          placeholder="Cari hijab..." 
          value="<?= htmlspecialchars($keyword) ?>"
        >
      </form>
      <!-- Tombol Keranjang -->
      <a href="cart.php" class="btn btn-primary">🛒 Keranjang</a>
    </div>
  </nav>

  <!-- Header Katalog -->
  <section class="page-header">
    <div class="container">
      <h1>Katalog Produk</h1>
      <p>Pilih koleksi hijab terbaik dari Hijabbyvla ✨</p>
    </div>
  </section>

  <!-- Produk -->
  <section class="produk">
    <div class="container">
      <?php if ($keyword): ?>
        <p style="margin-bottom: 15px;">Hasil pencarian untuk: <b><?= htmlspecialchars($keyword) ?></b></p>
      <?php endif; ?>

      <div class="produk-list">
        <?php if (count($produk) > 0): ?>
          <?php foreach ($produk as $pr): ?>
            <div class="card">
              <?php if (!empty($pr['image'])): ?>
                <img src="../<?= $pr['image'] ?>" alt="<?= htmlspecialchars($pr['name']) ?>">
              <?php else: ?>
                <img src="images/no-image.png" alt="No Image">
              <?php endif; ?>
              <div class="card-body">
                <h3><?= htmlspecialchars($pr['name']) ?></h3>
                <p class="price">Rp<?= number_format($pr['price'],0,',','.') ?></p>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="id" value="<?= $pr['id'] ?>">
                  <input type="hidden" name="name" value="<?= htmlspecialchars($pr['name']) ?>">
                  <input type="hidden" name="price" value="<?= $pr['price'] ?>">
                  <input type="hidden" name="image" value="<?= htmlspecialchars($pr['image']) ?>">
                  <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                </form>
                <br>
                <a href="detail_produk.php?id=<?= $pr['id'] ?>" class="btn btn-primary">Detail Produk</a>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-muted">Produk tidak ditemukan.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <footer class="footer">
    <div class="container">
      <p>© 2025 hijabbyvla. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>
