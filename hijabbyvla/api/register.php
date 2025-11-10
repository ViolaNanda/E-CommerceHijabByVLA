<?php
require_once("../config.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $role = $_POST["role"] ?? "pelanggan";

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)");
    try {
        $stmt->execute([$name, $email, $passwordHash, $role]);
        echo "Registrasi berhasil. <a href='../public/login.html'>Login sekarang</a>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
