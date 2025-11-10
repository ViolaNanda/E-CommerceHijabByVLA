<?php
session_start();
require_once("../config.php");

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../public/login.html");
    exit;
}

if (!isset($_GET['id'])) {
    die("ID pesanan tidak ditemukan.");
}

$order_id = $_GET['id'];

// Ambil data pesanan utama
$stmt_order = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt_order->execute([$order_id]);
$order = $stmt_order->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    die("Pesanan tidak ditemukan.");
}

// Ambil item pesanan
$stmt_items = $pdo->prepare("
    SELECT oi.*, p.name, p.price 
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$stmt_items->execute([$order_id]);
$items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);

// Update status jadi 'selesai' jika tombol diklik
if (isset($_POST['kirim'])) {
    $update = $pdo->prepare("UPDATE orders SET status = 'selesai' WHERE id = ?");
    $update->execute([$order_id]);
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #fafafa; }
        .card { border: none; border-radius: 12px; }
        .btn-brand {
            background: linear-gradient(90deg,#e91e63,#9c27b0);
            border: none;
            color: #fff;
        }
        .btn-brand:hover { opacity: .9; color: #fff; }
    </style>
</head>
<body>
<div class="container my-5">
    <h3 class="mb-4 fw-bold text-center">Detail Pesanan #<?= $order['id'] ?></h3>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <p><strong>Nama Customer:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
            <p><strong>Status:</strong> 
                <span class="badge bg-warning text-dark"><?= ucfirst($order['status']) ?></span>
            </p>
            <p><strong>Tanggal Pesan:</strong> <?= $order['created_at'] ?></p>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white fw-bold">Daftar Produk</div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>Rp<?= number_format($item['price'],0,',','.') ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>Rp<?= number_format($item['price'] * $item['quantity'],0,',','.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-end mb-4">
        <h5>Total Harga: <strong>Rp<?= number_format($order['total'],0,',','.') ?></strong></h5>
    </div>

    <form method="POST">
        <button type="submit" name="kirim" class="btn btn-brand">Kirim (Tandai Selesai)</button>
        <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
    </form>
</div>
</body>
</html>
