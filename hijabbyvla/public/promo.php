<?php
require_once "../config.php";

// Promo statis otomatis untuk tanggal kembar
$today = date("d");
$double_date = substr($today, 0, 1) === substr($today, 1, 1); // misal 11, 22
$promo_custom = [];

if ($double_date) {
  $promo_custom[] = [
    'title' => '✨ Promo Tanggal Kembar - Beli 1 Gratis 1 ✨',
    'description' => 'Spesial hari ini, setiap pembelian 1 hijab akan mendapatkan 1 hijab GRATIS! Berlaku hanya pada tanggal kembar seperti hari ini!',
    'image' => '../images/promo-b1g1.jpg'
  ];
}

// Ambil promo dari database (jika ada)
$stmt = $pdo->query("SELECT * FROM promos ORDER BY created_at DESC");
$promos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Gabungkan promo dari database + promo tanggal kembar
$all_promos = array_merge($promo_custom, $promos);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Promo Hijab - Hijabbyvla</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    :root {
      --primary: #e91e63;
      --secondary: #9c27b0;
      --light-pink: #fce4ec;
      --muted: #555;
      --shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: #fff7fb;
      margin: 0;
      padding: 0;
      color: #333;
    }

    /* Navbar */
    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #fff;
      padding: 15px 40px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .logo {
      font-size: 24px;
      font-weight: bold;
      color: var(--primary);
    }
    .logo span {
      color: var(--secondary);
    }
    .nav-links {
      display: flex;
      list-style: none;
      gap: 20px;
    }
    .nav-links a {
      text-decoration: none;
      color: #333;
      font-weight: 500;
    }
    .nav-links a:hover,
    .nav-links a.active {
      color: var(--primary);
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
    .btn-cart {
      background: linear-gradient(90deg, var(--primary), var(--secondary));
      color: #fff;
      border: none;
      border-radius: 8px;
      padding: 8px 15px;
      cursor: pointer;
      transition: opacity 0.2s;
    }
    .btn-cart:hover {
      opacity: 0.9;
    }

    /* Header Promo */
    .promo-header {
      text-align: center;
      padding: 60px 20px;
      background: linear-gradient(120deg, var(--primary), var(--secondary));
      color: white;
      border-radius: 0 0 40px 40px;
      box-shadow: var(--shadow);
    }
    .promo-header h1 {
      font-size: 36px;
      margin-bottom: 10px;
    }
    .promo-header p {
      font-size: 16px;
      opacity: 0.9;
    }

    /* Grid Promo */
    .promo-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 25px;
      margin: 50px auto;
      max-width: 1100px;
      padding: 0 20px;
    }

    .promo-card {
      background: #fff;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: var(--shadow);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      position: relative;
    }

    .promo-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .promo-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }

    .promo-body {
      padding: 20px;
      text-align: center;
    }

    .promo-body h3 {
      font-size: 20px;
      margin-bottom: 10px;
      color: var(--primary);
    }

    .promo-body p {
      font-size: 14px;
      color: #555;
    }

    /* Label promo spesial */
    .badge {
      position: absolute;
      top: 12px;
      left: 12px;
      background: var(--primary);
      color: white;
      padding: 6px 12px;
      border-radius: 12px;
      font-size: 13px;
      font-weight: 500;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }

    /* Footer (disamakan temanya dengan header) */
    .footer {
      text-align: center;
      padding: 25px;
      background: linear-gradient(120deg, var(--primary), var(--secondary));
      color: white;
      box-shadow: 0 -2px 6px rgba(0,0,0,0.05);
      border-radius: 40px 40px 0 0;
    }
    .footer p {
      margin: 0;
      font-size: 14px;
      opacity: 0.95;
    }

    @media (max-width: 600px) {
      .promo-header h1 {
        font-size: 28px;
      }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar">
    <div class="logo">HijabBy<span>VLA</span></div>
    <ul class="nav-links">
      <li><a href="index.php">Beranda</a></li>
      <li><a href="katalog.php">Katalog</a></li>
      <li><a href="tentang.php">Tentang</a></li>
      <li><a href="promo.php" class="active">Promo</a></li>
    </ul>
    <div class="nav-right">
      <input type="text" class="search" placeholder="Cari hijab...">
      <button class="btn-cart" onclick="window.location='cart.php'">🛒 Keranjang</button>
    </div>
  </nav>

  <!-- Header Promo -->
  <section class="promo-header">
    <h1>🎀 Promo Spesial Hijabbyvla 🎀</h1>
    <p>Temukan berbagai penawaran menarik dan hemat setiap bulannya 💕</p>
  </section>

  <!-- Daftar Promo -->
  <section class="promo-grid">
    <?php if (count($all_promos) > 0): ?>
      <?php foreach ($all_promos as $promo): ?>
        <div class="promo-card">
          <div class="badge">Promo</div>
          <img src="<?= htmlspecialchars($promo['image']) ?>" alt="<?= htmlspecialchars($promo['title']) ?>">
          <div class="promo-body">
            <h3><?= htmlspecialchars($promo['title']) ?></h3>
            <p><?= htmlspecialchars($promo['description']) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p style="grid-column:1/-1; text-align:center; color:#888;">Belum ada promo untuk saat ini.</p>
    <?php endif; ?>
  </section>

  <footer class="footer">
    <p>© 2025 hijabbyvla. All rights reserved.</p>
  </footer>

</body>
</html>
