<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tentang Kami - Hijabbyvla</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    /* Header */
    .about-header {
      text-align: center;
      padding: 60px 20px;
      background: linear-gradient(90deg, #e91e63, #9c27b0);
      color: #fff;
      border-radius: 0 0 20px 20px;
      margin-bottom: 40px;
    }
    .about-header h1 {
      font-size: 36px;
      font-weight: bold;
      margin-bottom: 10px;
    }
    .about-header p {
      font-size: 18px;
      opacity: 0.9;
    }

    /* Konten */
    .about-container {
      max-width: 900px;
      margin: 0 auto;
      padding: 20px;
      line-height: 1.8;
    }
    .about-container h2 {
      color: #e91e63;
      margin-top: 30px;
      margin-bottom: 10px;
      font-size: 24px;
    }
    .about-container p {
      color: #444;
      font-size: 16px;
    }

    /* Card nilai */
    .values {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-top: 30px;
    }
    .value-card {
      background: #fff;
      border-radius: 12px;
      padding: 20px;
      text-align: center;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .value-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 16px rgba(0,0,0,0.15);
    }
    .value-card h3 {
      color: #9c27b0;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="container nav-content">
      <div class="logo">HijabBy<span>VLA</span></div>
      <ul class="nav-links">
        <li><a href="index.php">Beranda</a></li>
        <li><a href="katalog.php">Katalog</a></li>
        <li><a href="tentang.php" class="active">Tentang</a></li>
        <li><a href="promo.php">Promo</a></li>
      </ul>
      <div class="nav-right">
        <input type="text" class="search" placeholder="Cari hijab...">
        <button class="btn btn-primary btn-cart" onclick="window.location.href='cart.php'">Keranjang</button>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <section class="about-header">
    <h1>Tentang Hijabbyvla</h1>
    <p>Kenyamanan, keanggunan, dan kualitas dalam setiap helai hijab ✨</p>
  </section>

  <!-- Konten -->
  <div class="about-container">
    <h2>Siapa Kami?</h2>
    <p>
      Hijabbyvla adalah brand hijab lokal yang hadir untuk mendukung setiap muslimah tampil percaya diri 
      dengan koleksi hijab berkualitas tinggi. Kami percaya bahwa hijab bukan hanya penutup kepala, 
      tetapi juga cerminan gaya, identitas, dan keanggunan.
    </p>

    <h2>Visi Kami</h2>
    <p>
      Menjadi brand hijab terpercaya yang menghadirkan kenyamanan, inovasi desain, 
      dan kualitas premium bagi setiap wanita muslimah di Indonesia dan mancanegara.
    </p>

    <h2>Misi Kami</h2>
    <p>
      Memberikan produk hijab dengan material terbaik, memperhatikan detail desain yang elegan, 
      serta melayani pelanggan dengan sepenuh hati.
    </p>

    <!-- Nilai Keunggulan -->
    <div class="values">
      <div class="value-card">
        <h3>🌸 Kualitas Premium</h3>
        <p>Bahan lembut, nyaman, dan tahan lama untuk menunjang aktivitas sehari-hari.</p>
      </div>
      <div class="value-card">
        <h3>🎨 Desain Elegan</h3>
        <p>Koleksi motif dan warna yang selalu mengikuti tren tanpa meninggalkan kesan anggun.</p>
      </div>
      <div class="value-card">
        <h3>💖 Pelayanan Ramah</h3>
        <p>Kepuasan pelanggan adalah prioritas kami, dari pemesanan hingga pengiriman.</p>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <p>© 2025 hijabbyvla. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>
