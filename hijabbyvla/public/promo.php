<?php
require_once "../config.php";

// Ambil semua promo
$stmt = $pdo->query("SELECT * FROM promos ORDER BY created_at DESC");
$promos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Promo Hijab - Hijabbyvla</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    .promo-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 20px;
      margin-top: 30px;
    }
    .promo-card {
      background: linear-gradient(135deg, #fce7f3, #faf5ff);
      border-radius: 20px;
      overflow: hidden;
      box-shadow: var(--shadow);
      transition: transform 0.3s ease;
    }
    .promo-card:hover {
      transform: translateY(-5px);
    }
    .promo-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }
    .promo-body {
      padding: 16px;
    }
    .promo-body h3 {
      font-size: 18px;
      margin-bottom: 8px;
      color: var(--primary);
    }
    .promo-body p {
      font-size: 14px;
      color: var(--muted);
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="container nav-content">
      <div class="logo">hijabby<span>vla</span></div>
      <ul class="nav-links">
        <li><a href="index.php">Beranda</a></li>
        <li><a href="katalog.php">Katalog</a></li>
        <li><a href="tentang.php">Tentang</a></li>
      </ul>
      <div class="nav-right">
        <input type="text" class="search" placeholder="Cari hijab...">
        <button class="btn-cart">Keranjang (0)</button>
      </div>
    </div>
  </nav>

  <!-- Promo Section -->
  <section class="container" style="margin-top:40px;">
    <h2 style="text-align:center; margin-bottom:20px;">🎉 Promo Spesial Hijabbyvla 🎉</h2>
    <p style="text-align:center; color:var(--muted); margin-bottom:40px;">
      Jangan lewatkan promo terbaik kami
    </p>

    <div class="promo-grid">
      <?php if (count($promos) > 0): ?>
        <?php foreach ($promos as $pr): ?>
          <div class="promo-card">
            <img src="../uploads/<?= htmlspecialchars($pr['image']) ?>" alt="<?= htmlspecialchars($pr['title']) ?>">
            <div class="promo-body">
              <h3><?= htmlspecialchars($pr['title']) ?></h3>
              <p><?= htmlspecialchars($pr['description']) ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p style="grid-column:1/-1; text-align:center; color:var(--muted);">Belum ada promo.</p>
      <?php endif; ?>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <p>© 2025 hijabbyvla. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>
