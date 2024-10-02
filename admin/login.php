<?php
  include "../inc/connect.php";
  session_name('admin_session');
  session_start();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
      echo "<script>alert('Harap lengkapi semua informasi yang diperlukan!')</script>";
    } else {
      $sql = "SELECT * FROM admin WHERE username = ? ";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param('s', $username);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password == password_verify($password, $row['password'])) {
          echo "<script>alert('Login berhasil!')</script>";

          $_SESSION['nama_admin'] = $username;
          echo "<script>window.location.href = 'index.php'</script>";
          $found = true;
          $stmt->close();
          exit;
        } else {
          echo "<script>alert('Password anda salah!')</script>";
        }
      } else {
        echo "<script>alert('Akun tidak ditemukan!')</script>";
      }
    }
  }
  
  $conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | APP PERPUS</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="./assets/css/login_daftar.css">
  <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
</head>
<body>
  <div class="container">
    <h1>App Perpustakaan</h1>
    <form action="" method="POST">
      <div class="logo">
        <img src="assets/img/favicon2.png" alt="logo perpustakaan">
      </div>
      <h2>Login</h2>
      <input class="login" type="username" name="username" id="username" placeholder="Username" required>
      <div class="password">
        <input type="password" name="password" id="password" placeholder="Password" required>
        <i class="fa-regular fa-eye-slash" id="eyeBtn"></i>
      </div>
      <button type="submit">Login</button>
      <div class="daftar">
        <span>Belum punya akun? | <a href="daftar.php">Daftar</a></span>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const eyeBtn = document.getElementById('eyeBtn');
      const inputPass = document.querySelector("input[type = 'password']"); 

      eyeBtn.addEventListener('click', function() {
        if (eyeBtn.classList.contains("fa-eye-slash")) {
          eyeBtn.classList.remove('fa-eye-slash');
          eyeBtn.classList.add('fa-eye');
          inputPass.setAttribute('type', 'text');
        } else {
          eyeBtn.classList.remove('fa-eye');
          eyeBtn.classList.add('fa-eye-slash');
          inputPass.setAttribute('type', 'password');
        }
      });

      if (localStorage.getItem("darkModeAdmin") === "enabled") {
        setMode("dark");
      } else {
        setMode("light");
      }
      function setMode(mode) {
        if (mode == "dark") {
          document.body.classList.add("active");
          localStorage.setItem("darkModeAdmin", "enabled");
        } else if (mode == "light") {
          document.body.classList.remove("active");
          localStorage.setItem("darkModeAdmin", "disabled");
        }
      }
    });
  </script>
</body>
</html>