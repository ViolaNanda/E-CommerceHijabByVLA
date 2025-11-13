<?php
// kamu bisa tambahkan include config kalau butuh database
// require_once("../config.php");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hijabbyvla - Elegan Tiap Hari</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    /* tambahan styling khusus landing */
    .hero {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 80px 10%;
      background: linear-gradient(135deg, #f9f9f9, #ffe6f0);
    }
    .hero-text {
      max-width: 50%;
    }
    .hero-text h1 {
      font-size: 2.5rem;
      color: #333;
    }
    .hero-text span {
      color: #d63384;
    }
    .hero-text p {
      margin: 15px 0;
      font-size: 1.1rem;
      color: #555;
    }
    .hero-text .btn-primary {
      padding: 10px 20px;
      background: #d63384;
      color: #fff;
      border: none;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
    }
    .hero img {
      max-width: 40%;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .features {
      text-align: center;
      padding: 60px 10%;
    }
    .features h2 {
      margin-bottom: 30px;
      color: #333;
    }
    .feature-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }
    .feature-card {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }
    .feature-card h3 {
      margin-bottom: 10px;
      color: #d63384;
    }

    .cta {
      background: #d63384;
      color: #fff;
      text-align: center;
      padding: 50px 10%;
    }
    .cta h2 {
      margin-bottom: 20px;
    }
    .cta a {
      padding: 12px 25px;
      background: #fff;
      color: #d63384;
      font-weight: bold;
      border-radius: 5px;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="container nav-content">
      <div class="logo">HijabBy<span>VLA</span></div>
      <div class="nav-right">
        <a href="register.php" class="btn btn-primary">Register</a>
        <a href="Login.php" class="btn btn-primary">Login</a>
      </div> 
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-text">
      <h1>Elegan tiap hari dengan <span>HijabByVLA</span></h1>
      <p>Koleksi hijab premium: pashmina, segi empat, dan voal dengan bahan nyaman serta motif menarik.</p>
      <a href="register.php" class="btn-primary">Belanja Sekarang</a>
    </div>
    <img src="images/toko.jpg" alt="Hijab Collection">
  </section>

  <!-- Features -->
  <section class="features">
    <h2>Kenapa pilih Hijabbyvla?</h2>
    <div class="feature-grid">
      <div class="feature-card">
        <h3>Bahan Premium</h3>
        <p>Nyaman dipakai seharian dengan kualitas terbaik.</p>
      </div>
      <div class="feature-card">
        <h3>Motif Kekinian</h3>
        <p>Desain eksklusif yang selalu update mengikuti tren.</p>
      </div>
      <div class="feature-card">
        <h3>Harga Terjangkau</h3>
        <p>Kualitas premium dengan harga ramah di kantong.</p>
      </div>
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
