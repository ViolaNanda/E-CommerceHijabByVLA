<?php
require_once("../config.php");

// ambil data produk dari database
$produk = $pdo->query("SELECT * FROM products ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hijabbyvla</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    /* Produk Unggulan - Horizontal Scroll */
    .produk-list {
      display: flex;
      gap: 20px;
      overflow-x: auto;
      padding: 10px 0;
      scroll-behavior: smooth;
    }

    .produk-list::-webkit-scrollbar {
      height: 8px;
    }
    .produk-list::-webkit-scrollbar-thumb {
      background: #ccc;
      border-radius: 10px;
    }

    .produk .card {
      min-width: 220px;
      max-width: 220px;
      flex-shrink: 0;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      text-align: center;
      transition: 0.3s;
    }

    .produk .card img {
      width: 100%;
      height: 220px;
      object-fit: cover;
      border-top-left-radius: 12px;
      border-top-right-radius: 12px;
    }

    .produk .card-body {
      padding: 10px;
    }

    .produk .card-body h3 {
      font-size: 16px;
      margin: 6px 0;
    }

    .produk .card-body .price {
      font-weight: bold;
      color: #f77f00;
    }

    .produk-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }

    .produk-header h2 {
      margin: 0;
    }

    .produk-header a {
      text-decoration: none;
      color: #f77f00;
      font-weight: 600;
    }

    /* Tombol di navbar */
    .nav-right {
      display: flex;
      gap: 10px;
      align-items: center;
    }
    .btn {
      padding: 8px 16px;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }
    .btn-primary {
      background: linear-gradient(90deg, #e91e63, #9c27b0);
      color: #fff;
    }
    .btn-profil {
      background: #35b125ff;
      color: #fff;
    }
    .btn:hover {
      opacity: 0.9;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="container nav-content">
      <div class="logo">HijabBy<span>VLA</span></div>
      <ul class="nav-links">
        <li><a href="#">Beranda</a></li>
        <li><a href="katalog.php">Katalog</a></li>
        <li><a href="tentang.php">Tentang</a></li>
        <li><a href="promo.php">Promo</a></li>
      </ul>
      <div class="nav-right">
        <button class="btn btn-primary btn-cart" onclick="window.location.href='cart.php'">🛒 Keranjang</button>
        <button class="btn btn-primary" onclick="window.location.href='rekap_pesanan.php'">📦 Rekap Pesanan</button>
        <button class="btn btn-profil" onclick="window.location.href='profil.php'">👤 Profil</button>
      </div>
    </div>
  </nav>

  <!-- Hero -->
  <section class="hero">
    <div class="hero-text">
      <h1>Elegan tiap hari dengan <span>HijabByVLA</span></h1>
      <p>Pashmina, segi empat, dan voal premium — bahan nyaman, motif menarik. Pilih favoritmu dan checkout dengan mudah.</p>
      <div class="hero-buttons">
        <a href="katalog.php" class="btn-ghost">Belanja Sekarang</a>
        <a href="galeri.php" class="btn-ghost">Gallery</a>
      </div>
    </div>

    <div class="hero-slider">
      <div class="slides">
        <img src="images/toko1.jpg" alt="Hijab 2">
        <img src="images/toko.jpg" alt="Hijab 1">
        <img src="images/toko5.jpg" alt="Hijab 3">
      </div>
      <button class="prev">&#10094;</button>
      <button class="next">&#10095;</button>
    </div>
  </section>

  <!-- Promo Section -->
  <section class="promo">
    <div class="container">
      <div class="promo-card">
        <h3>✨ Diskon Spesial November!</h3>
        <p>Pilih promo dan dapatkan hijab pilihanmu dengan harga yang lebih murah.</p>
        <button class="btn btn-primary btn-cart" onclick="window.location.href='promo.php'">Lihat Promo</button>
      </div>
    </div>
  </section>

  <!-- Produk Unggulan -->
  <section class="produk">
    <div class="container">
      <div class="produk-header">
        <h2>Produk Unggulan</h2>
        <a href="katalog.php">Lihat semua →</a>
      </div>
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
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-muted">Belum ada produk tersedia.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <p>© 2025 hijabbyvla. All rights reserved.</p>
    </div>
  </footer>

  <!-- JS -->
  <script>
    let currentIndex = 0;
    const slides = document.querySelector(".hero-slider .slides");
    const totalSlides = document.querySelectorAll(".hero-slider img").length;

    document.querySelector(".next").addEventListener("click", () => {
      moveSlide(1);
    });

    document.querySelector(".prev").addEventListener("click", () => {
      moveSlide(-1);
    });

    function moveSlide(step) {
      currentIndex = (currentIndex + step + totalSlides) % totalSlides;
      slides.style.transform = `translateX(-${currentIndex * 100}%)`;
    }

    // Auto slide setiap 4 detik
    setInterval(() => {
      moveSlide(1);
    }, 4000);
  </script>
</body>
</html>
