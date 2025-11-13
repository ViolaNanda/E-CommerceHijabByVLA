<?php
require_once("../config.php");

// Ambil data produk berdasarkan ID
if (!isset($_GET["id"])) {
    header("Location: dashboard.php");
    exit;
}
$id = $_GET["id"];
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$produk = $stmt->fetch();

if (!$produk) {
    echo "Produk tidak ditemukan.";
    exit;
}

// Update data produk
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $description = $_POST["description"];
    $image = $produk["image"]; // default pakai gambar lama

    // Jika upload gambar baru
    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "../uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image = "uploads/" . $fileName;

            // Hapus gambar lama kalau ada
            if (!empty($produk["image"]) && file_exists("../" . $produk["image"])) {
                unlink("../" . $produk["image"]);
            }
        }
    }

    $stmt = $pdo->prepare("UPDATE products SET name=?, price=?, stock=?, description=?, image=? WHERE id=?");
    $stmt->execute([$name, $price, $stock, $description, $image, $id]);

    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Produk - Hijabbyvla</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #fafafa; }
    .brand-gradient { background: linear-gradient(90deg,#e91e63,#9c27b0); }
    .btn-brand {
      background: linear-gradient(90deg,#e91e63,#9c27b0);
      border: none;
      color: #fff;
    }
    .btn-brand:hover { opacity: .9; color:#fff; }
    .card { border: none; border-radius: 12px; }
    .navbar-brand span { color:#e91e63; }
    .product-img {
      max-width: 120px;
      border-radius: 8px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark brand-gradient shadow-sm">
    <div class="container-fluid px-4">
      <a class="navbar-brand fw-bold" href="dashboard.php">Admin <span>Hijabbyvla</span></a>
      <div class="d-flex">
        <a href="dashboard.php" class="btn btn-light btn-sm">Kembali</a>
      </div>
    </div>
  </nav>

  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-7">
        <div class="card shadow-sm">
          <div class="card-header bg-white fw-bold text-center">
            Edit Produk
          </div>
          <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
              <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($produk['name']) ?>" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" name="price" class="form-control" value="<?= $produk['price'] ?>" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stock" class="form-control" value="<?= $produk['stock'] ?>" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($produk['description']) ?></textarea>
              </div>
              <div class="mb-3">
                <label class="form-label">Foto Produk</label><br>
                <?php if (!empty($produk['image'])): ?>
                  <img src="../<?= $produk['image'] ?>" alt="Produk" class="product-img"><br>
                <?php endif; ?>
                <input type="file" name="image" class="form-control" accept="image/*">
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-brand">Simpan Perubahan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
