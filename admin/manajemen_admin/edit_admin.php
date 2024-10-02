<?php
  // Mengambil sekaligus memvalidasi data array yang berisi data admin yang akan di edit dari file kelola_data.php 
  if (!(isset($_SESSION['template_admin'])) || $_SESSION['template_admin'] == '')  {
    header('Location: ?page=dasbhoard');
    exit;
  } else {
    $row = $_SESSION['template_admin'];
  }

  if (isset($_POST['ubah'])) {
    $idAdmin = trim($_POST['idAdmin']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);

    $sql = "UPDATE admin SET username = ?, email = ? WHERE id_admin = '$idAdmin'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $username, $email);
    if ($stmt->execute()) {
      echo "<script>alert('Data admin berhasil diubah!');</script>";
    } else {
      echo "<script>alert('Data admin gagal diubah');</script>";
    }
    echo "<script>window.location.href = '?page=daftar_admin';</script>";
    // $_SESSION['nama_admin'] = $_POST['username'] == $_SESSION['nama_admin'] ? $username : '';

    $_SESSION['template_admin'] = '';
    $stmt->close();
    exit;
  }
  $conn->close();
?>

<div class="tBukuWrapper">
  <h1><i class="fas fa-user-cog"></i> <span>Edit Admin</span></h1>
  <form action="" method="POST">
    <ul>
      <li>
        <div class="box-label">
          <label for="idAdmin">ID Admin </label>
        </div>
        <span>:</span>
        <div class="box-input">
          <input type="text" name="idAdmin" id="idAdmin" value="<?= $row['id_admin']; ?>" readonly>
        </div>
      </li>
      <li>
        <div class="box-label">
          <label for="username">Username </label>
        </div>
        <span>:</span>
        <div class="box-input">
          <input type="text" name="username" id="username" placeholder="Username" value="<?= $row['username']; ?>" required>
        </div>
      </li>
      <li>
        <div class="box-label">
          <label for="email">Email </label>
        </div>
        <span>:</span>
        <div class="box-input">
          <input type="text" name="email" id="email" placeholder="Email" value="<?= $row['email']; ?>" required>
        </div>
      </li>
      <li>
        <div class="box-label">
          <label for="level">Level </label>
        </div>
        <span>:</span>
        <div class="box-input">
          <input type="text" name="level" id="level" value="Admin" readonly>
        </div>
      </li>
    </ul>

    <div class="btn">
      <button class="simpan" type="submit" name="ubah">Ubah</button>
      <button type="reset" class="batal-edit"><a href="?page=daftar_admin">Batal</a></button>
    </div>
  </form>
</div>