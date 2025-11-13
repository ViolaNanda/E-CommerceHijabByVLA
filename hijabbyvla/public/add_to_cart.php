<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = floatval($_POST['price']);
    $image = isset($_POST['image']) ? $_POST['image'] : '';

    if (!empty($id) && !empty($name) && $price > 0) {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['qty'] += 1;
        } else {
            $_SESSION['cart'][$id] = [
                'id' => $id,
                'name' => $name,
                'price' => $price,
                'qty' => 1,
                'image' => $image
            ];
        }

        // Simpan pesan sukses di session
        $_SESSION['success_message'] = "✅ Berhasil menambahkan <b>{$name}</b> ke keranjang!";
    }

    header("Location: katalog.php");
    exit;
}

header("Location: katalog.php");
exit;
?>
