<?php
  // Mengambil sekaligus memvalidasi data array yang berisi data buku yang akan di edit dari file kelola_data.php 
  if (!(isset($_SESSION['template_buku'])) || $_SESSION['template_buku'] == '')  {
    header('Location: ?page=daftar_buku');
    exit;
  } else {
    $row = $_SESSION['template_buku'];
  }

  // Mengataur button 'ubah' di form edit buku. 
  if (isset($_POST['ubah'])) {
    $idBuku = trim($_POST['idBuku']);
    $judulBuku = trim($_POST['judulBuku']);
    $pengarang = trim($_POST['pengarang']);
    $penerbit = trim($_POST['penerbit']);
    $tahunTerbit = trim($_POST['tahunTerbit']);

    $sql = "UPDATE buku SET judul_buku = ?, pengarang = ?, penerbit = ?, tahun_terbit = ? WHERE id_buku = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssss', $judulBuku, $pengarang, $penerbit, $tahunTerbit, $idBuku);
    if ($stmt->execute()) {
      echo "<script>alert('Data buku berhasil diubah!');</script>";
    } else {
      echo "<script>alert('Data buku gagal diubah');</script>";
    }
    echo "<script>window.location.href = '?page=daftar_buku';</script>";
    $_SESSION['template_buku'] = '';
    $stmt->close();
    exit;
  }
  $conn->close();
?>

<div class="tBukuWrapper">
  <h1><i class="fas fa-edit"></i> <span>Edit Buku</span></h1>
  <form action="" method="POST">
    <ul>
      <li>
        <div class="box-label">
          <label for="idBuku">ID Buku </label>
        </div>
        <span>:</span>
        <div class="box-input">
          <input type="text" name="idBuku" id="idBuku" value="<?= $row['id_buku']; ?>" readonly>
        </div>
      </li>
      <li>
        <div class="box-label">
          <label for="judulBuku">Judul Buku </label>
        </div>
        <span>:</span>
        <div class="box-input">
          <input type="text" name="judulBuku" id="judulBuku" placeholder="Judul Buku" value="<?= $row['judul_buku']; ?>" required>
        </div>
      </li>
      <li>
        <div class="box-label">
          <label for="pengarang">Pengarang </label>
        </div>
        <span>:</span>
        <div class="box-input">
          <input type="text" name="pengarang" id="pengarang" placeholder="Nama Pengarang" value="<?= $row['pengarang']; ?>" required>
        </div>
      </li>
      <li>
        <div class="box-label">
          <label for="penerbit">Penerbit </label>
        </div>
        <span>:</span>
        <div class="box-input">
          <input type="text" name="penerbit" id="penerbit" placeholder="Penerbit" value="<?= $row['penerbit']; ?>" required>
        </div>
      </li>
      <li>
        <div class="box-label">
          <label for="tahunTerbit">Tahun Terbit</label>
        </div>
        <span>:</span>
        <div class="box-input">
          <input type="number" name="tahunTerbit" id="tahunTerbit" placeholder="Tahun Terbit"  value="<?= $row['tahun_terbit']; ?>" inputmode="numeric" required>
        </div>
      </li>
    </ul>

    <div class="btn">
      <button class="simpan" type="submit" name="ubah">Ubah</button>
      <button type="reset" class="batal-edit"><a href="?page=daftar_buku">Batal</a></button>
    </div>
  </form>
</div>