<?php
require_once("../config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $description = $_POST["description"];

    // Handle upload gambar
    $image = null;
    if (!empty($_FILES["image"]["name"])) {
        $targetDir = "../uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileName = time() . "_" . basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image = "uploads/" . $fileName;
        }
    }

    // Simpan ke database
    $stmt = $pdo->prepare("INSERT INTO products (name, price, stock, description, image) VALUES (?,?,?,?,?)");
    $stmt->execute([$name, $price, $stock, $description, $image]);

    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Produk - Hijabbyvla</title>
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
            Tambah Produk Baru
          </div>
          <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
              <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="name" class="form-control" placeholder="Contoh: Pashmina Ceruty" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" name="price" class="form-control" placeholder="65000" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stock" class="form-control" placeholder="100" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" class="form-control" rows="4" placeholder="Tuliskan detail produk..." required></textarea>
              </div>
              <div class="mb-3">
                <label class="form-label">Pilihan Warna</label>
                <div class="d-flex flex-wrap gap-2">

                    <!-- Warna Hitam -->
                    <input type="checkbox" class="btn-check" id="warnaHitam" name="colors[]" value="Hitam" autocomplete="off">
                    <label class="btn btn-outline-dark" for="warnaHitam">Hitam</label>

                    <!-- Warna Navy -->
                    <input type="checkbox" class="btn-check" id="warnaNavy" name="colors[]" value="Navy" autocomplete="off">
                    <label class="btn btn-outline-primary" for="warnaNavy">Navy</label>

                    <!-- Warna Dusty Pink -->
                    <input type="checkbox" class="btn-check" id="warnaDustyPink" name="colors[]" value="Dusty Pink" autocomplete="off">
                    <label class="btn btn-outline-danger" for="warnaDustyPink">Dusty Pink</label>

                    <!-- Warna Army -->
                    <input type="checkbox" class="btn-check" id="warnaArmy" name="colors[]" value="Army" autocomplete="off">
                    <label class="btn btn-outline-success" for="warnaArmy">Army</label>

                    <!-- Warna Abu -->
                    <input type="checkbox" class="btn-check" id="warnaAbu" name="colors[]" value="Abu" autocomplete="off">
                    <label class="btn btn-outline-secondary" for="warnaAbu">Abu</label>

                </div>

              <div class="mb-3">
                <label class="form-label">Foto Produk</label>
                <input type="file" name="image" class="form-control" accept="image/*">
              </div>
              <div class="d-grid">
                <button type="submit" a href="notifikasi.php" class="btn btn-brand">Simpan Produk</button></a>
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
