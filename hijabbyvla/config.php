<?php
// config.php
// Konfigurasi koneksi database

$DB_HOST = '127.0.0.1';
$DB_NAME = 'hijabbyvla';
$DB_USER = 'root';
$DB_PASS = '';

try {
    // Buat koneksi PDO
    $pdo = new PDO(
        "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4",
        $DB_USER,
        $DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // munculkan error jelas
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // hasil fetch jadi array asosiatif
            PDO::ATTR_EMULATE_PREPARES => false, // lebih aman untuk SQL
        ]
    );
} catch (PDOException $e) {
    // Jika gagal koneksi, tampilkan pesan error
    die("Koneksi database gagal: " . $e->getMessage());
}
?>
