<?php
session_start();
require_once("../config.php"); // kalau perlu akses database

// Ambil data dari form
$id = $_POST['id'];
$name = $_POST['name'];
$price = $_POST['price'];
$image = $_POST['image'] ?? '';

// Pastikan keranjang ada di session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Kalau produk belum ada di cart → tambahkan
if (!isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id] = [
        'id' => $id,           // ✅ Tambahkan baris ini
        'name' => $name,
        'price' => $price,
        'quantity' => 1,
        'image' => $image
    ];
} else {
    // Kalau produk sudah ada → tambahkan jumlah
    $_SESSION['cart'][$id]['quantity'] += 1;
}

// Redirect balik ke halaman keranjang
header("Location: cart.php");
exit;
?>
