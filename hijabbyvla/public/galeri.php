<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Koleksi Hijab - Hijabbyvla</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    .gallery {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 20px;
      margin-top: 30px;
    }
    .gallery img {
      width: 100%;
      height: 250px;
      object-fit: cover;
      border-radius: 16px;
      box-shadow: var(--shadow);
      transition: transform 0.3s ease;
    }
    .gallery img:hover {
      transform: scale(1.05);
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
        <li><a href="katalog.php" class="active">Katalog</a></li>
        <li><a href="tentang.php">Tentang</a></li>
        <li><a href="promo.php">Promo</a></li>
      </ul>
      <div class="nav-right">
        <input type="text" class="search" placeholder="Cari hijab...">
        <button class="btn-cart">Keranjang (0)</button>
      </div>
    </div>
  </nav>

  <!-- Koleksi -->
  <section class="container" style="margin-top:40px;">
    <h2 style="text-align:center; margin-bottom:20px;">✨ Galeri HijabByVLA ✨</h2>
    <p style="text-align:center; color:var(--muted); margin-bottom:40px;">
      Kumpulan foto-foto brand kami...
    </p>

    <div class="gallery">
      <img src="images/testi.jpg" alt="Hijab Collection">
      <img src="images/testi1.jpg" alt="Hijab Collection">
      <img src="images/paket.jpg" alt="Hijab Collection">
      <img src="images/paket1.jpg" alt="Hijab Collection">
      <img src="images/hampers.jpg" alt="Hijab Collection">
      <img src="images/testi2.jpg" alt="Hijab Collection">
      <img src="images/hamidah.jpg" alt="Hijab Collection">
      <img src="images/toko2.jpg" alt="Hijab Collection">
      <img src="images/toko3.jpg" alt="Hijab Collection">
      <img src="images/toko4.jpg" alt="Hijab Collection">
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
