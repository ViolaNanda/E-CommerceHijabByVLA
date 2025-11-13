<?php
// kalau user sudah login bisa diarahkan langsung ke dashboard
// session_start();
// if (isset($_SESSION['user_id'])) {
//   header("Location: dashboard.php");
//   exit;
// }
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Hijabbyvla</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f9f9f9;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .form-container {
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      width: 350px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .form-container h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #d63384;
    }
    .form-container input {
      width: 100%;
      padding: 12px;
      margin: 8px 0;
      border: 1px solid #ddd;
      border-radius: 8px;
    }
    .form-container button {
      width: 100%;
      padding: 12px;
      background: #d63384;
      border: none;
      color: #fff;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
      margin-top: 10px;
    }
    .form-container p {
      text-align: center;
      margin-top: 15px;
      font-size: 14px;
    }
    .form-container a {
      color: #d63384;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Login</h2>
    <form action="../api/login.php" method="POST">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
  </div>
</body>
</html>
