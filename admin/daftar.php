<?php
include "../inc/connect.php";
session_name('admin_session');
session_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = trim($_POST['email']);
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  $confirm_password = trim($_POST['confirm_password']);

  if(empty($email) || empty($username) || empty($password)) {
    echo "<script>alert('Harap lengkapi semua informasi yang diperlukan!')</script>";
  } else {
    if ($password == $confirm_password) {

      $cek_sql = "SELECT * FROM admin WHERE email = ?  OR username = ?";
      $stmt = $conn->prepare($cek_sql);
      $stmt->bind_param('ss', $email, $username);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        echo "<script>alert('Akun ini sudah terdaftar!')</script>";
      } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO admin (username, email,  password) VALUES (?, ?, ?)";
        $stmt= $conn->prepare($sql);
        $stmt->bind_param('sss', $username, $email, $password);

        if ($stmt->execute()) {
          echo "<script>alert('Pendaftaran akun berhasil!')</script>";

          $_SESSION['nama_admin'] = $_POST['username'];
          echo "<script>window.location.href = 'login.php'</script>";
          $stmt->close();
          exit;
        } else {
          echo "<script>alert('Ada kesalahan. Mohon coba lagi...')</script>";
        }
      }
    } else {
      echo "<script>alert('Tolong masukkan password dan confirm password dengan benar.')</script>";
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
  <title>Daftar | APP PERPUS</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="./assets/css/login_daftar.css">
  <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
</head>
<body>
  <div class="container daftar">
    <h1>App Perpustakaan</h1>
    <form action="" method="POST">
      <div class="logo">
        <img src="assets/img/favicon2.png" alt="logo perpustakaan">
      </div>
      <h2>Daftar</h2>
      <div class="box-input">
        <input class="daftar" type="email" name="email" id="email" placeholder="Email" required>
        <input class="daftar" type="text" name="username" id="username" placeholder="Username" required>
        <div class="password">
          <input type="password" name="password" id="password" placeholder="Password" required>
          <i class="fa-regular fa-eye-slash" id="eyeBtn"></i>
        </div>
        <div class="password">
          <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password" required>
          <i class="fa-regular fa-eye-slash" id="eyeBtn"></i>
        </div>
      </div>
      <button type="submit" class="btn-login">Daftar</button>
      <div class="daftar">
        <span>Sudah punya akun? | <a href="login.php">Masuk</a></span>
      </div>
    </form>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const eyeBtn = Array.from(document.querySelectorAll('#eyeBtn'));
      const inputPass = Array.from(document.querySelectorAll("input[type = 'password']")); 

      eyeBtn.forEach((value, index) => {
        value.addEventListener('click', function() {
          if (value.classList.contains("fa-eye-slash")) {
            value.classList.remove('fa-eye-slash');
            value.classList.add('fa-eye');
            inputPass[index].setAttribute('type', 'text');
          } else {
            value.classList.remove('fa-eye');
            value.classList.add('fa-eye-slash');
            inputPass[index].setAttribute('type', 'password');
          }
        });
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