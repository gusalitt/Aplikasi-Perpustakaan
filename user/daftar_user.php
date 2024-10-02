<?php
include "../inc/connect.php";
session_name('user_session');
session_start();

// Membuat Id pengguna secara otomatis.
function generated_ID($conn) {
  $sql = "SELECT id_pengguna FROM pengguna ORDER BY id_pengguna DESC LIMIT 1";
  $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lasID = $row['id_pengguna'];
    $num = (intval(substr($lasID, 1))) + 1;
    $new_ID = "Z" . str_pad($num, 3, "0", STR_PAD_LEFT);
  } else {
    $new_ID = "Z001";
  }
  return $new_ID;
}
$new_ID = generated_ID($conn);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $idPengguna = trim($_POST['idPengguna']);
  $nama_pengguna = trim($_POST['namaPenggunaDaftar']);
  $gender = trim($_POST['gender']);
  $alamat = trim($_POST['alamat']);
  $no_telp = trim($_POST['noHp']);
  $password = trim($_POST['password']);

  if(empty($idPengguna) || empty($nama_pengguna) || empty($password) || empty($gender) || empty($alamat) || empty($no_telp)) {
    echo "<script>alert('Harap lengkapi semua informasi yang diperlukan!')</script>";
  } else {
      $cek_sql = "SELECT * FROM pengguna WHERE nama_pengguna = ?  OR no_hp = ? ";
      $stmt = $conn->prepare($cek_sql);
      $stmt->bind_param('ss', $nama_pengguna, $no_telp);
      $stmt->execute();
      $result = $stmt->get_result();
      $stmt->close();

      if ($result->num_rows > 0) {
        echo "<script>alert('Akun ini sudah terdaftar!')</script>";
      } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO pengguna (id_pengguna, nama_pengguna, jenis_kelamin, alamat, no_hp, password ) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssss', $idPengguna, $nama_pengguna, $gender, $alamat, $no_telp, $password);

        if ($stmt->execute()) {
          echo "<script>alert('Pendaftaran akun berhasil!')</script>";

          $_SESSION['id_pengguna'] = $idPengguna;
          $_SESSION['nama_pengguna'] = $nama_pengguna;
          $_SESSION['gender'] = $gender;
          $_SESSION['alamat'] = $alamat;
          $_SESSION['no_telp'] = $no_telp;

          $redirect = isset($_SESSION['page_redirect']) ? $_SESSION['page_redirect'] : 'index.php';
          echo "<script>window.location.href = '$redirect'</script>";

          unset($_SESSION['page_redirect']);
          $stmt->close();
          exit;
        } else {
          echo "<script>alert('Ada kesalahan. Mohon coba lagi...')</script>";
        }
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

  <div class="add-data">
    <button class="close"><i class="fa-solid fa-xmark"></i></button>
    <div class="logo">
      <span><img src="assets/img/favicon2.png" alt=""> App Perpustakaan</span>
      <h1>Gabung Sekarang dan Mulai Petualangan Membaca!</h1>
    </div>

    <form action="" method="POST">
      <ul>
        <input type="hidden" name="idPengguna" id="idPengguna" value="<?= $new_ID; ?>" readonly hidden>
        <li>
          <div class="box-label">
            <label for="namaPenggunaDaftar">Nama </label>
          </div>
          <span>:</span>
          <div class="box-input">
            <input type="text" name="namaPenggunaDaftar" id="namaPenggunaDaftar" placeholder="Nama Pengguna" required>
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
        <li>
          <div class="box-label">
            <label for="gender">Gender </label>
          </div>
          <span>:</span>
          <div class="box-input">
            <select type="text" name="gender" id="gender" required>
              <option value="" disabled selected>-- Pilih --</option>
              <option value="Laki - Laki">Laki - laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </div>
        </li>
        <li>
          <div class="box-label">
            <label for="alamat">Alamat </label>
          </div>
          <span>:</span>
          <div class="box-input">
            <input type="text" name="alamat" id="alamat" placeholder="Alamat" required>
          </div>
        </li>
        <li>
          <div class="box-label">
            <label for="noHp">No Telp</label>
          </div>
          <span>:</span>
          <div class="box-input">
            <input type="tel" name="noHp" id="noHp" placeholder="No Telp" inputmode="numeric" required>
          </div>
        </li>
      </ul>

      <div class="btn">
        <button type="submit" name="daftar" value="daftar">Daftar</button>
      </div>

      <p class="login">Sudah pernah jadi member ? <a href="login_user.php">Login</a>
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