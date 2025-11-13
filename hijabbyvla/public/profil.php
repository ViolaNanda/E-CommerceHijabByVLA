<?php
session_start();
require_once("../config.php");

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

// Ambil data user dari database
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Jika data user tidak ditemukan
if (!$user) {
  echo "Data pengguna tidak ditemukan.";
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profil Saya - Hijabbyvla</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    body {
      background-color: #fff;
      font-family: 'Poppins', sans-serif;
    }
    .container {
      max-width: 900px;
      margin: 60px auto;
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      padding: 40px;
    }
    h2 {
      text-align: center;
      color: #e91e63;
      margin-bottom: 30px;
    }
    .profile-info {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
    }
    .profile-info img {
      width: 130px;
      height: 130px;
      border-radius: 50%;
      object-fit: cover;
      border: 4px solid #f77f00;
      margin-bottom: 15px;
    }
    .profile-info table {
      width: 100%;
      max-width: 500px;
      border-collapse: collapse;
      margin-top: 15px;
    }
    .profile-info td {
      padding: 10px;
      border-bottom: 1px solid #eee;
      font-size: 16px;
    }
    .profile-info td:first-child {
      font-weight: bold;
      color: #555;
      width: 40%;
    }
    .btn {
      display: inline-block;
      margin-top: 25px;
      padding: 10px 20px;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      background: linear-gradient(90deg, #e91e63, #9c27b0);
      color: #fff;
      cursor: pointer;
      transition: 0.3s;
    }
    .btn:hover {
      opacity: 0.9;
    }
  </style>
</head>
<body>

  <!-- Navbar (sama seperti halaman utama) -->
  <nav class="navbar">
    <div class="container nav-content">
      <div class="logo">HijabBy<span>VLA</span></div>
      <ul class="nav-links">
        <li><a href="index.php">Beranda</a></li>
        <li><a href="katalog.php">Katalog</a></li>
        <li><a href="tentang.php">Tentang</a></li>
        <li><a href="promo.php">Promo</a></li>
      </ul>
      <div class="nav-right">
        <button class="btn btn-primary" onclick="window.location.href='cart.php'">🛒 Keranjang</button>
        <button class="btn btn-secondary" onclick="window.location.href='rekap_pesanan.php'">📦 Rekap</button>
        <button class="btn" style="background:#4CAF50;" onclick="window.location.href='profil.php'">👤 Profil</button>
      </div>
    </div>
  </nav>

  <div class="container">
    <h2>Profil Saya</h2>
    <div class="profile-info">
      <img src="<?php echo !empty($user['photo']) ? '../' . htmlspecialchars($user['photo']) : 'images/default-user.png'; ?>" alt="Foto Profil">
      <table>
        <tr>
          <td>Nama Lengkap</td>
          <td><?= htmlspecialchars($user['fullname']) ?></td>
        </tr>
        <tr>
          <td>Username</td>
          <td><?= htmlspecialchars($user['username']) ?></td>
        </tr>
        <tr>
          <td>Email</td>
          <td><?= htmlspecialchars($user['email']) ?></td>
        </tr>
        <tr>
          <td>Tanggal Daftar</td>
          <td><?= date('d F Y', strtotime($user['created_at'])) ?></td>
        </tr>
      </table>
      <button class="btn" onclick="window.location.href='edit_profil.php'">✏️ Edit Profil</button>
      <button class="btn" style="background:#f44336;" onclick="window.location.href='logout.php'">🚪 Logout</button>
    </div>
  </div>

</body>
</html>
