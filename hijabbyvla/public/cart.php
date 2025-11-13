<?php
session_start();

// Pastikan keranjang selalu ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Pastikan semua item punya qty minimal 1
foreach ($_SESSION['cart'] as $key => $value) {
    if (!isset($value['qty']) || $value['qty'] < 1) {
        $_SESSION['cart'][$key]['qty'] = 1;
    }
}

// Tambah produk ke keranjang (dari katalog)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = trim($_POST['id']);
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);

    if ($id !== '' && $name !== '' && $price > 0) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty'] += 1;
        } else {
            $_SESSION['cart'][$id] = [
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'qty' => 1
            ];
        }
    }

    header("Location: cart.php");
    exit;
}

// Hapus produk dari keranjang
if (isset($_GET['remove'])) {
    $removeId = $_GET['remove'];
    if (isset($_SESSION['cart'][$removeId])) {
        unset($_SESSION['cart'][$removeId]);
    }
    header("Location: cart.php");
    exit;
}

// Tambah atau kurangi qty
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    if (isset($_SESSION['cart'][$id])) {
        if ($_GET['action'] === 'plus') {
            $_SESSION['cart'][$id]['qty']++;
        } elseif ($_GET['action'] === 'minus') {
            $_SESSION['cart'][$id]['qty']--;
            if ($_SESSION['cart'][$id]['qty'] < 1) {
                unset($_SESSION['cart'][$id]);
            }
        }
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
    body { font-family: 'Poppins', sans-serif; background: #fafafa; margin: 0; }
    .container { max-width: 1000px; margin: 40px auto; padding: 20px; }
    .card { background: #fff; padding: 25px; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    h1 { text-align: center; margin-bottom: 25px; background: linear-gradient(90deg,#e91e63,#9c27b0); -webkit-background-clip: text; color: transparent; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    table th, table td { padding: 14px; text-align: center; border-bottom: 1px solid #eee; }
    table th { background: #f8f8f8; font-weight: bold; }
    .btn { padding: 8px 14px; border: none; border-radius: 8px; cursor: pointer; transition: 0.3s; text-decoration: none; display: inline-block; font-weight: 500; }
    .btn-primary { background: linear-gradient(90deg,#e91e63,#9c27b0); color: #fff; }
    .btn-danger { background: #f44336; color: #fff; }
    .btn:hover { opacity: 0.9; transform: translateY(-1px); }
    .qty-control { display: flex; align-items: center; justify-content: center; gap: 5px; }
    .qty-btn { background: #e91e63; color: white; border: none; border-radius: 50%; width: 30px; height: 30px; font-size: 18px; cursor: pointer; line-height: 1; }
    .qty-btn:hover { background: #c2185b; }
    .qty-num { font-weight: bold; color: #333; width: 30px; text-align: center; }
    .total { text-align: right; font-size: 20px; margin-top: 15px; font-weight: bold; color: #9c27b0; }
    .actions { text-align: right; margin-top: 20px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; }
    .back-btn {
      background: linear-gradient(90deg, #9c27b0, #e91e63);
      color: #fff;
      border: none;
      padding: 10px 18px;
      border-radius: 8px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      text-decoration: none;
    }
    .back-btn:hover {
      opacity: 0.9;
      transform: translateX(-3px);
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <h1>🛒 Keranjang Belanja</h1>

      <!-- Tombol Back -->
      <div style="margin-bottom: 20px;">
        <a href="index.php" class="back-btn">← Kembali ke Beranda</a>
      </div>

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
              $qty = isset($item['qty']) ? (int)$item['qty'] : 1;
              $total = $item['price'] * $qty;
              $grandTotal += $total;
            ?>
            <tr>
              <td><?= htmlspecialchars($item['name']) ?></td>
              <td>Rp<?= number_format($item['price'],0,',','.') ?></td>
              <td>
                <div class="qty-control">
                  <a href="cart.php?action=minus&id=<?= urlencode($id) ?>" class="qty-btn">−</a>
                  <span class="qty-num"><?= $qty ?></span>
                  <a href="cart.php?action=plus&id=<?= urlencode($id) ?>" class="qty-btn">+</a>
                </div>
              </td>
              <td>Rp<?= number_format($total,0,',','.') ?></td>
              <td><a href="cart.php?remove=<?= urlencode($id) ?>" class="btn btn-danger">Hapus</a></td>
            </tr>
          <?php endforeach; ?>
        </table>
        <div class="total">Total: Rp<?= number_format($grandTotal,0,',','.') ?></div>
        <div class="actions">
          <a href="katalog.php" class="back-btn">← Kembali Belanja</a>
          <a href="checkout.php" class="btn btn-primary">Lanjut ke Checkout →</a>
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
