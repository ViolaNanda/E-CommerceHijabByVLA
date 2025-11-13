<?php
require_once("../config.php");

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$produk = $stmt->fetch();

if (!$produk) {
  echo "Produk tidak ditemukan.";
  exit;
}

// Ambil semua gambar jika kamu nanti punya tabel images (sementara pakai 1 gambar utama)
$images = [$produk['image']];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($produk['name']) ?> - Hijabbyvla</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    body {
      background: #fdfdfd;
      color: #333;
      font-family: 'Poppins', sans-serif;
    }
    .page-header {
      text-align: center;
      padding: 40px 20px;
      background: linear-gradient(90deg, #e91e63, #9c27b0);
      color: #fff;
      border-radius: 0 0 20px 20px;
      margin-bottom: 30px;
    }
    .produk-detail {
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      justify-content: center;
      align-items: flex-start;
      padding: 20px;
    }
    .produk-images {
      flex: 1 1 350px;
      max-width: 400px;
    }
    .produk-images img {
      width: 100%;
      border-radius: 12px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    .produk-info {
      flex: 1 1 350px;
      max-width: 400px;
    }
    .produk-info h2 {
      font-size: 26px;
      margin-bottom: 10px;
      color: #333;
    }
    .produk-info .price {
      font-size: 22px;
      color: #e91e63;
      font-weight: bold;
      margin-bottom: 20px;
    }
    .produk-info p {
      margin-bottom: 20px;
      line-height: 1.6;
    }
    .btn {
      display: inline-block;
      padding: 10px 18px;
      border-radius: 8px;
      background: linear-gradient(90deg,#e91e63,#9c27b0);
      color: #fff;
      text-decoration: none;
      margin-right: 10px;
      transition: opacity 0.2s;
    }
    .btn:hover {
      opacity: 0.9;
    }
    .slider {
      position: relative;
    }
    .slider img {
      display: none;
    }
    .slider img.active {
      display: block;
    }
    .slider-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(0,0,0,0.5);
      color: white;
      border: none;
      padding: 10px;
      cursor: pointer;
      border-radius: 50%;
    }
    .prev { left: 10px; }
    .next { right: 10px; }
  </style>
</head>
<body>

  <nav class="navbar">
    <div class="container nav-content">
      <div class="logo">hijabby<span>vla</span></div>
      <ul class="nav-links">
        <li><a href="index.php">Beranda</a></li>
        <li><a href="katalog.php">Katalog</a></li>
        <li><a href="tentang.php">Tentang</a></li>
        <li><a href="promo.php">Promo</a></li>
      </ul>
    </div>
  </nav>

  <section class="page-header">
    <h1>Detail Produk</h1>
  </section>

  <div class="container produk-detail">
    <div class="produk-images slider">
      <?php foreach ($images as $i => $img): ?>
        <img src="../<?= $img ?>" alt="<?= htmlspecialchars($produk['name']) ?>" class="<?= $i == 0 ? 'active' : '' ?>">
      <?php endforeach; ?>
      <?php if (count($images) > 1): ?>
        <button class="slider-btn prev" onclick="changeSlide(-1)">❮</button>
        <button class="slider-btn next" onclick="changeSlide(1)">❯</button>
      <?php endif; ?>
    </div>

    <div class="produk-info">
      <h2><?= htmlspecialchars($produk['name']) ?></h2>
      <div class="price">Rp<?= number_format($produk['price'],0,',','.') ?></div>
      <p><?= nl2br(htmlspecialchars($produk['description'])) ?></p>

      <form action="add_to_cart.php" method="POST" style="display:inline;">
        <input type="hidden" name="id" value="<?= $produk['id'] ?>">
        <input type="hidden" name="name" value="<?= htmlspecialchars($produk['name']) ?>">
        <input type="hidden" name="price" value="<?= $produk['price'] ?>">
        <input type="hidden" name="image" value="<?= htmlspecialchars($produk['image']) ?>">
        <button type="submit" class="btn">Tambah ke Keranjang</button>
      </form>

      <a href="checkout.php?id=<?= $produk['id'] ?>" class="btn">Beli Sekarang</a>
    </div>
  </div>

  <footer class="footer">
    <div class="container">
      <p>© 2025 hijabbyvla. All rights reserved.</p>
    </div>
  </footer>

  <script>
    let current = 0;
    const slides = document.querySelectorAll('.slider img');

    function changeSlide(n) {
      slides[current].classList.remove('active');
      current = (current + n + slides.length) % slides.length;
      slides[current].classList.add('active');
    }
  </script>
</body>
</html>
