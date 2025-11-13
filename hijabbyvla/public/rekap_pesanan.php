<?php
// rekap_pesanan.php
session_start();
require_once '../config.php'; // pastikan file config.php berisi koneksi PDO ke database

// --- Jika admin klik "Kirim Pesanan", ubah status jadi "Dikirim" ---
if (isset($_GET['kirim'])) {
    $id = intval($_GET['kirim']);
    $update = $pdo->prepare("UPDATE orders SET status = 'Dikirim' WHERE id = ?");
    $update->execute([$id]);

    if ($update) {
        echo "<script>alert('Pesanan telah dikirim!'); window.location='rekap_pesanan.php';</script>";
        exit;
    }
}

// Ambil semua pesanan dari database (tabel `orders`)
$result = $pdo->query("SELECT * FROM orders ORDER BY created_at DESC");
$pesanan = $result->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Rekap Pesanan - Hijabbyvla</title>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #fafafa;
        margin: 0;
        padding: 0;
    }
    .container {
        max-width: 1000px;
        margin: 40px auto;
        background: #fff;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    h1 {
        text-align: center;
        margin-bottom: 30px;
        background: linear-gradient(90deg,#e91e63,#9c27b0);
        -webkit-background-clip: text;
        color: transparent;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    table th, table td {
        padding: 14px;
        border-bottom: 1px solid #eee;
        text-align: center;
    }
    table th {
        background: #f9f9f9;
        font-weight: 600;
    }
    .btn {
        padding: 8px 14px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        text-decoration: none;
        transition: 0.3s;
        font-size: 14px;
    }
    .btn-primary {
        background: linear-gradient(90deg,#e91e63,#9c27b0);
        color: #fff;
    }
    .btn-disabled {
        background: #9e9e9e;
        color: #fff;
        cursor: not-allowed;
    }
    .btn:hover {
        opacity: 0.9;
    }
    .status {
        font-weight: bold;
        padding: 6px 12px;
        border-radius: 8px;
        text-transform: capitalize;
    }
    .Dikemas { background: #fff3cd; color: #856404; }
    .Dikirim { background: #d4edda; color: #155724; }
    .back {
        display: inline-block;
        margin-bottom: 15px;
        padding: 8px 16px;
        background: #e91e63;
        color: white;
        border-radius: 10px;
        text-decoration: none;
    }
    .back:hover { background: #c2185b; }
</style>
</head>
<body>
<div class="container">
    <a href="index.php" class="back">⬅ Kembali ke Dashboard</a>
    <h1>📦 Rekap Pesanan</h1>

    <table>
        <tr>
            <th>ID</th>
            <th>Nama Pelanggan</th>
            <th>Total Harga</th>
            <th>Status</th>
            <th>Tanggal Pesan</th>
            <th>Aksi</th>
        </tr>
        <?php if (count($pesanan) > 0): ?>
            <?php foreach ($pesanan as $row): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['customer_name']) ?></td>
                <td>Rp<?= number_format($row['total'],0,',','.') ?></td>
                <td>
                    <span class="status <?= $row['status'] ?>">
                        <?= $row['status'] ?>
                    </span>
                </td>
                <td><?= date('d M Y H:i', strtotime($row['created_at'])) ?></td>
                <td>
                    <?php if ($row['status'] === 'Dikemas'): ?>
                        <a href="rekap_pesanan.php?kirim=<?= $row['id'] ?>" class="btn btn-primary">Kirim Pesanan</a>
                    <?php else: ?>
                        <button class="btn btn-disabled">Sudah Dikirim</button>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6" style="text-align:center;">Belum ada pesanan</td></tr>
        <?php endif; ?>
    </table>
</div>
</body>
</html>
