<?php
  // Mengambil sekaligus memvalidasi data array yang berisi data pengguna yang akan di edit dari file kelola_data.php 
  if (!(isset($_SESSION['template_pengguna'])) || $_SESSION['template_pengguna'] == '')  {
    header('Location: ?page=daftar_pengguna');
    exit;
  } else {
    $row = $_SESSION['template_pengguna'];
  }

  // Mengatur button 'ubah' di form edit buku. 
  if (isset($_POST['ubah'])) {
    $idPengguna = trim($_POST['idPengguna']);
    $namaPengguna = trim($_POST['namaPengguna']);
    $jKelamin = trim($_POST['jKelamin']);
    $alamat = trim($_POST['alamat']);
    $noHp = trim($_POST['noHp']);

    $cek_sql = "SELECT * FROM pengguna WHERE (nama_pengguna = ?  OR no_hp = ?) AND id_pengguna != ?";
    $stmt = $conn->prepare($cek_sql);
    $stmt->bind_param('sss', $namaPengguna, $noHp, $idPengguna);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      echo "<script>alert('Data pengguna tersebut telah terdaftar!')</script>";
    } else {
      $sql = "UPDATE pengguna SET nama_pengguna = ?, jenis_kelamin = ?, alamat = ?, no_hp = ? WHERE id_pengguna = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param('sssss', $namaPengguna, $jKelamin, $alamat, $noHp, $idPengguna);
      if ($stmt->execute()) {
        echo "<script>alert('Data pengguna berhasil diubah!');</script>";
      } else {
        echo "<script>alert('Data pengguna gagal diubah');</script>";
      }
      echo "<script>window.location.href = '?page=daftar_pengguna';</script>";
      $_SESSION['template_pengguna'] = '';
      $stmt->close();
      exit;
    }
  }
  $conn->close();
?>

<div class="tPenggunaWrapper">
  <h1><i class="fa-solid fa-user-pen"></i> <span>Edit Pengguna</span></h1>

  <form action="" method="POST">
    <ul>
      <li>
        <div class="box-label">
          <label for="idPengguna">ID pengguna </label>
        </div>
        <span>:</span>
        <div class="box-input">
          <input type="text" name="idPengguna" id="idPengguna" value="<?= $row['id_pengguna']; ?>" readonly>
        </div>
      </li>
      <li>
        <div class="box-label">
          <label for="namaPengguna">Nama Pengguna </label>
        </div>
        <span>:</span>
        <div class="box-input">
          <input type="text" name="namaPengguna" id="namaPengguna" placeholder="Nama Pengguna" value="<?= $row['nama_pengguna']; ?>" required>
        </div>
      </li>
      <li>
        <div class="box-label">
          <label for="jKelamin">Jenis Kelamin </label>
        </div>
        <span>:</span>
        <div class="box-input">
          <select type="text" name="jKelamin" id="jKelamin" required>
            <?php if ($row['jenis_kelamin'] == "Laki - laki") : ?>
                  <option value="Laki - laki" selected>Laki - laki</option>
            <?php else : ?>
                <option value="Laki - laki">Laki - laki</option>
            <?php endif; ?>

            <?php if ($row['jenis_kelamin'] == "Perempuan") : ?>
                  <option value="Perempuan" selected>Perempuan</option>
            <?php else : ?>
                <option value="Perempuan">Perempuan</option>
            <?php endif; ?>
          </select>
        </div>
      </li>
      <li>
        <div class="box-label">
          <label for="alamat">Alamat </label>
        </div>
        <span>:</span>
        <div class="box-input">
          <input type="text" name="alamat" id="alamat" placeholder="Alamat" value="<?= $row['alamat']; ?>" required>
        </div>
      </li>
      <li>
        <div class="box-label">
          <label for="noHp">No HP</label>
        </div>
        <span>:</span>
        <div class="box-input">
          <input type="tel" name="noHp" id="noHp" placeholder="No HP" value="<?= $row['no_hp']; ?>" inputmode="numeric" required>
        </div>
      </li>
    </ul>
  
    <div class="btn">
      <button class="simpan" type="submit"  name="ubah">Ubah</button>
      <button type="reset" class="batal-edit"><a href="?page=daftar_pengguna">Batal</a></button>
    </div>
  </form>
</div>