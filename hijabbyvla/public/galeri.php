<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Galeri Hijab - Hijabbyvla</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    :root {
      --primary: #e91e63;
      --secondary: #9c27b0;
      --light: #fff0f6;
      --text: #333;
      --shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(180deg, #fff, #fff0f6);
      margin: 0;
      color: var(--text);
    }

    /* Navbar */
    .navbar {
      background: linear-gradient(90deg, var(--primary), var(--secondary));
      padding: 15px 40px;
      color: white;
      box-shadow: var(--shadow);
    }
    .nav-content {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
    }
    .logo {
      font-size: 26px;
      font-weight: bold;
      letter-spacing: 1px;
    }
    .logo span {
      color: #ffe6f0;
    }
    .nav-links {
      list-style: none;
      display: flex;
      gap: 20px;
    }
    .nav-links a {
      color: white;
      text-decoration: none;
      font-weight: 500;
      position: relative;
    }
    .nav-links a::after {
      content: "";
      position: absolute;
      width: 0;
      height: 2px;
      background: white;
      left: 0;
      bottom: -5px;
      transition: 0.3s;
    }
    .nav-links a:hover::after,
    .nav-links a.active::after {
      width: 100%;
    }
    .nav-right {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .search {
      padding: 6px 12px;
      border-radius: 20px;
      border: none;
      outline: none;
      width: 180px;
    }
    .btn-cart {
      background: white;
      color: var(--primary);
      border: none;
      padding: 8px 15px;
      border-radius: 20px;
      cursor: pointer;
      transition: all 0.3s;
      font-weight: 600;
    }
    .btn-cart:hover {
      background: var(--light);
      transform: translateY(-2px);
    }

    /* Header */
    .gallery-header {
      text-align: center;
      padding: 60px 20px;
      background: linear-gradient(120deg, #f8bbd0, #e1bee7);
      color: #fff;
      border-radius: 0 0 30px 30px;
      box-shadow: var(--shadow);
    }
    .gallery-header h1 {
      font-size: 34px;
      margin-bottom: 10px;
      letter-spacing: 1px;
    }
    .gallery-header p {
      font-size: 16px;
      opacity: 0.9;
    }

    /* Gallery */
    .gallery {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
      gap: 25px;
      margin: 40px auto;
      max-width: 1200px;
      padding: 0 20px;
    }
    .gallery-item {
      position: relative;
      overflow: hidden;
      border-radius: 16px;
      box-shadow: var(--shadow);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .gallery-item img {
      width: 100%;
      height: 260px;
      object-fit: cover;
      display: block;
      transition: transform 0.4s ease;
    }
    .gallery-item:hover img {
      transform: scale(1.08);
      filter: brightness(85%);
    }
    .gallery-item::after {
      content: "✨ Hijabbyvla ✨";
      position: absolute;
      bottom: -40px;
      left: 0;
      right: 0;
      background: rgba(255,255,255,0.8);
      color: var(--secondary);
      text-align: center;
      padding: 10px;
      font-weight: 600;
      border-top-left-radius: 16px;
      border-top-right-radius: 16px;
      transition: bottom 0.3s ease;
    }
    .gallery-item:hover::after {
      bottom: 0;
    }

    /* Footer */
    .footer {
      background: linear-gradient(90deg, var(--secondary), var(--primary));
      color: white;
      text-align: center;
      padding: 20px;
      border-radius: 20px 20px 0 0;
      margin-top: 40px;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <section class="gallery-header">
    <h1>✨ Galeri Hijabbyvla ✨</h1>
    <p>Lihat koleksi dan momen spesial dari brand kami 💕</p>
  </section>

  <!-- Gallery -->
  <div class="gallery">
    <div class="gallery-item"><img src="images/testi.jpg" alt="Hijab Collection"></div>
    <div class="gallery-item"><img src="images/testi1.jpg" alt="Hijab Collection"></div>
    <div class="gallery-item"><img src="images/paket.jpg" alt="Hijab Collection"></div>
    <div class="gallery-item"><img src="images/paket1.jpg" alt="Hijab Collection"></div>
    <div class="gallery-item"><img src="images/paket2.jpg" alt="Hijab Collection"></div>
    <div class="gallery-item"><img src="images/resi.jpg" alt="Hijab Collection"></div>
    <div class="gallery-item"><img src="images/toko2.jpg" alt="Hijab Collection"></div>
    <div class="gallery-item"><img src="images/toko3.jpg" alt="Hijab Collection"></div>
    <div class="gallery-item"><img src="images/toko4.jpg" alt="Hijab Collection"></div>
    <div class="gallery-item"><img src="images/toko5.jpg" alt="Hijab Collection"></div>
    <div class="gallery-item"><img src="images/hampers.jpg" alt="Hijab Collection"></div>
    <div class="gallery-item"><img src="images/hampers1.jpg" alt="Hijab Collection"></div>
    <div class="gallery-item"><img src="images/hampers2.jpg" alt="Hijab Collection"></div>
    <div class="gallery-item"><img src="images/hampers3.jpg" alt="Hijab Collection"></div>
    <div class="gallery-item"><img src="images/hampers4.jpg" alt="Hijab Collection"></div>
    <div class="gallery-item"><img src="images/hampers5.jpg" alt="Hijab Collection"></div>
  </div>

  <!-- Footer -->
  <footer class="footer">
    <p>© 2025 hijabbyvla. All rights reserved. | Designed with 💖</p>
  </footer>
</body>
</html>
