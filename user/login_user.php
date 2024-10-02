<?php
  include "../inc/connect.php";
  session_name('user_session');
  session_start();

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pengguna = trim($_POST['namaPenggunaLogin']);
    $password = trim($_POST['password']);

    if (empty($nama_pengguna) || empty($password)) {
      echo "<script>alert('Harap lengkapi semua informasi yang diperlukan!')</script>";
    } else {
      $sql = "SELECT * FROM pengguna WHERE nama_pengguna = ? ";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param('s', $nama_pengguna);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
          echo "<script>alert('Login Berhasil!')</script>";
          
          $_SESSION['id_pengguna'] = $row['id_pengguna'];
          $_SESSION['nama_pengguna'] = $row['nama_pengguna'];
          $_SESSION['gender'] = $row['jenis_kelamin'];
          $_SESSION['alamat'] = $row['alamat'];
          $_SESSION['no_telp'] = $row['no_hp'];

          $redirect = isset($_SESSION['page_redirect']) ? $_SESSION['page_redirect'] : 'index.php';
          echo "<script>window.location.href = '$redirect'</script>";

          unset($_SESSION['page_redirect']);
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
  <title>App Perpus</title>
  <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="assets/css/login_daftar.css">
</head>

<body>

  <div class="login-data">
    <div class="logo">
      <span><img src="assets/img/favicon2.png" alt=""> App Perpustakaan</span>
      <h1>Ayo Masuk untuk Terus Membaca!</h1>
    </div>

    <form action="" method="POST">
      <ul>

        <li>
          <div class="box-label">
            <label for="namaPenggunaLogin">Nama </label>
          </div>
          <span>:</span>
          <div class="box-input">
            <input type="text" name="namaPenggunaLogin" id="namaPenggunaLogin" placeholder="Nama Pengguna" required>
          </div>
        </li>
        <li>
          <div class="box-label">
            <label for="password">Password </label>
          </div>
          <span>:</span>
          <div class="box-input">
            <input type="password" name="password" id="password" placeholder="Password" required>
          </div>
        </li>
      </ul>

      <div class="btn">
        <button type="submit" name="login" value="login">Login</button>
      </div>

      <p class="daftar">Belum pernah jadi member ? <a href="daftar_user.php">Daftar</a>
    </form>
  </div>

  <script>
    if (localStorage.getItem("darkModeUser") === "enabled") {
      setMode("dark");
    } else {
      setMode("light");
    }
    function setMode(mode) {
      if (mode == "dark") {
        document.body.classList.add("active");
        localStorage.setItem("darkModeUser", "enabled");
      } else if (mode == "light") {
        document.body.classList.remove("active");
        localStorage.setItem("darkModeUser", "disabled");
      }
    }
  </script>
</body>

</html>