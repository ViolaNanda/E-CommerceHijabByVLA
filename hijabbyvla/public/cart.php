<?php
session_start();

// Inisialisasi array cart agar tidak error saat kosong
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Tambah produk ke keranjang
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = floatval($_POST['price']); // pastikan harga berupa angka

    // Cegah error jika data kosong
    if ($id && $name && $price > 0) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty']++;
        } else {
            $_SESSION['cart'][$id] = [
                'id' => $id,          // ✅ tambahkan ini supaya checkout.php bisa pakai $item['id']
                'name' => $name,
                'price' => $price,
                'qty' => 1
            ];
        }
    }

    header("Location: cart.php");
    exit;
}

// Hapus produk
if (isset($_GET['remove'])) {
    $removeId = $_GET['remove'];
    if (isset($_SESSION['cart'][$removeId])) {
        unset($_SESSION['cart'][$removeId]);
    }
    header("Location: cart.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Keranjang - Hijabbyvla</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    body { font-family: Arial, sans-serif; background: #fafafa; }
    .container { max-width: 1000px; margin: 40px auto; padding: 20px; }
    .card { background: #fff; padding: 25px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    h1 { text-align: center; margin-bottom: 25px; background: linear-gradient(90deg,#e91e63,#9c27b0); -webkit-background-clip: text; color: transparent; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    table th, table td { padding: 14px; text-align: center; border-bottom: 1px solid #eee; }
    table th { background: #f8f8f8; font-weight: bold; }
    .btn { padding: 8px 14px; border: none; border-radius: 8px; cursor: pointer; transition: 0.3s; text-decoration: none; display: inline-block; }
    .btn-primary { background: linear-gradient(90deg,#e91e63,#9c27b0); color: #fff; }
    .btn-danger { background: #f44336; color: #fff; }
    .btn:hover { opacity: 0.9; }
    .total { text-align: right; font-size: 20px; margin-top: 15px; font-weight: bold; color: #9c27b0; }
    .actions { text-align: right; }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <h1>🛒 Keranjang Belanja</h1>
      <?php if (!empty($_SESSION['cart'])): ?>
        <table>
          <tr>
            <th>Produk</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Total</th>
            <th>Aksi</th>
          </tr>
          <?php $grandTotal = 0; ?>
          <?php foreach ($_SESSION['cart'] as $id => $item): ?>
            <?php 
              $total = $item['price'] * $item['qty'];
              $grandTotal += $total;
            ?>
            <tr>
              <td><?= htmlspecialchars($item['name']) ?></td>
              <td>Rp<?= number_format($item['price'],0,',','.') ?></td>
              <td><?= $item['qty'] ?></td>
              <td>Rp<?= number_format($total,0,',','.') ?></td>
              <td><a href="cart.php?remove=<?= urlencode($id) ?>" class="btn btn-danger">Hapus</a></td>
            </tr>
          <?php endforeach; ?>
        </table>
        <div class="total">Total: Rp<?= number_format($grandTotal,0,',','.') ?></div>
        <div class="actions">
          <a href="checkout.php" class="btn btn-primary">Lanjut ke Checkout</a>
        </div>
      <?php else: ?>
        <p style="text-align:center; font-size:18px;">Keranjang masih kosong 🛍️</p>
        <div style="text-align:center;">
          <a href="katalog.php" class="btn btn-primary">Belanja Sekarang</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
