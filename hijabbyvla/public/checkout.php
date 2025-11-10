<?php
session_start();
require_once("../config.php");

// Jika keranjang kosong, kembali ke katalog
if (empty($_SESSION['cart'])) {
    header("Location: katalog.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $pembayaran = $_POST['pembayaran'];
    $pengiriman = $_POST['pengiriman'];

    // Hitung total dari cart
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $qty = isset($item['qty']) ? $item['qty'] : 1;
        $total += $item['price'] * $qty;
    }

    // Simpan ke tabel orders
    $stmt = $pdo->prepare("INSERT INTO orders 
        (customer_name, address, phone, payment_method, shipping_method, total, status, created_at)
        VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())");
    $stmt->execute([$nama, $alamat, $telepon, $pembayaran, $pengiriman, $total]);

    // Ambil ID pesanan terakhir
    $order_id = $pdo->lastInsertId();

    // Simpan detail item pesanan
    $stmt_detail = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($_SESSION['cart'] as $id => $item) {
        $product_id = isset($item['id']) ? $item['id'] : $id; // gunakan $id jika 'id' tidak ada
        $qty = isset($item['qty']) ? $item['qty'] : 1;
        $stmt_detail->execute([$order_id, $product_id, $qty, $item['price']]);
    }

    // Kosongkan keranjang
    unset($_SESSION['cart']);

    // Redirect ke halaman sukses
    header("Location: sukses.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Checkout - Hijabbyvla</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    body { font-family: Arial, sans-serif; background: #fafafa; }
    .container { max-width: 650px; margin: 50px auto; padding: 30px; background: #fff; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    h1 { text-align: center; margin-bottom: 25px; background: linear-gradient(90deg,#e91e63,#9c27b0); -webkit-background-clip: text; color: transparent; }
    label { font-weight: bold; margin-top: 15px; display: block; }
    input, textarea, select { width: 100%; padding: 12px; margin-top: 5px; border: 1px solid #ccc; border-radius: 10px; }
    textarea { resize: none; }
    button { width: 100%; padding: 14px; margin-top: 25px; border: none; border-radius: 10px; background: linear-gradient(90deg,#e91e63,#9c27b0); color: #fff; font-size: 16px; cursor: pointer; transition: 0.3s; }
    button:hover { opacity: 0.9; }
  </style>
</head>
<body>
  <div class="container">
    <h1>📦 Checkout</h1>
    <form method="POST">
      <label>Nama Lengkap:</label>
      <input type="text" name="nama" required>

      <label>Alamat Pengiriman:</label>
      <textarea name="alamat" rows="3" required></textarea>

      <label>No. Telepon:</label>
      <input type="text" name="telepon" required>

      <label>Metode Pembayaran:</label>
      <select name="pembayaran" required>
        <option value="">-- Pilih --</option>
        <option value="transfer">Transfer Bank</option>
        <option value="cod">COD (Bayar di Tempat)</option>
        <option value="ewallet">E-Wallet (OVO, GoPay, Dana)</option>
      </select>

      <label>Metode Pengiriman:</label>
      <select name="pengiriman" required>
        <option value="">-- Pilih --</option>
        <option value="jne">JNE</option>
        <option value="jnt">J&T Express</option>
        <option value="pos">POS Indonesia</option>
        <option value="gosend">GoSend/GrabExpress</option>
      </select>

      <button type="submit">Buat Pesanan</button>
    </form>
  </div>
</body>
</html>
