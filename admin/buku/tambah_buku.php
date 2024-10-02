<?php
// Membuat Id buku secara otomatis.
function generated_ID($conn) {
  $sql = "SELECT id_buku FROM buku ORDER BY id_buku DESC LIMIT 1";
  $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lasID = $row['id_buku'];
    $num = (intval(substr($lasID, 1))) + 1;
    $new_ID = "A" . str_pad($num, 3, "0", STR_PAD_LEFT);
  } else {
    $new_ID = "A001";
  }
  return $new_ID;
}
$new_ID = generated_ID($conn);


// Memasukkan data buku ke database. 
if (isset($_POST['simpan'])) {
  $idBuku = trim($_POST['idBuku']);
  $judulBuku = trim($_POST['judulBuku']);
  $pengarang = trim($_POST['pengarang']);
  $penerbit = trim($_POST['penerbit']);
  $tahunTerbit = trim($_POST['tahunTerbit']);

  if (empty($idBuku) || empty($judulBuku) || empty($pengarang) || empty($penerbit) || empty($tahunTerbit)) {
    echo "<script>alert('Harap isi semua bidang input!');</script>";
  } else {
    $cek_sql = "SELECT * FROM buku WHERE judul_buku = ?  AND pengarang = ? AND penerbit = ? AND tahun_terbit = ?";
    $stmt = $conn->prepare($cek_sql);
    $stmt->bind_param('ssss', $judulBuku, $pengarang, $penerbit, $tahunTerbit);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      echo "<script>alert('Data Buku tersebut telah terdaftar!')</script>";
    } else {
      if ($tahunTerbit < 1901 || $tahunTerbit > 2155) {
        echo "<script>alert('Mohon masukkan tahun terbit yang valid!');</script>";
      } else {
        $sql = "INSERT INTO buku (id_buku, judul_buku, pengarang, penerbit, tahun_terbit ) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssss', $idBuku, $judulBuku, $pengarang, $penerbit, $tahunTerbit);
        if ($stmt->execute()) {
          echo "<script>alert('Data buku berhasil ditambah!');</script>";
        } else {
          echo "<script>alert('Data buku gagal ditambah');</script>";
        }
        echo "<script>window.location.href = '?page=daftar_buku';</script>";
        $stmt->close();
        exit;
      }
    }
  }
}
$conn->close();
?>
<div class="tBukuWrapper">
  <h1><i class="fa-solid fa-circle-plus"></i> <sp an>Tambah Buku</sp></h1>
  <form action="" method="POST">
    <ul>
      <li>
        <div class="box-label">
          <label for="idBuku">ID Buku </label>
        </div>
        <span>:</span>
        <div class="box-input">
          <input type="text" name="idBuku" id="idBuku" value="<?= $new_ID; ?>" readonly>
        </div>
      </li>
      <li>
        <div class="box-label">
          <label for="judulBuku">Judul Buku </label>
        </div>
        <span>:</span>
        <div class="box-input">
          <input type="text" name="judulBuku" id="judulBuku" placeholder="Judul Buku" required>
        </div>
      </li>
      <li>
        <div class="box-label">
          <label for="pengarang">Pengarang </label>
        </div>
        <span>:</span>
        <div class="box-input">
          <input type="text" name="pengarang" id="pengarang" placeholder="Nama Pengarang" required>
        </div>
      </li>
      <li>
        <div class="box-label">
          <label for="penerbit">Penerbit </label>
        </div>
        <span>:</span>
        <div class="box-input">
          <input type="text" name="penerbit" id="penerbit" placeholder="Penerbit" required>
        </div>
      </li>
      <li>
        <div class="box-label">
          <label for="tahunTerbit">Tahun Terbit</label>
        </div>
        <span>:</span>
        <div class="box-input">
          <input type="number" name="tahunTerbit" id="tahunTerbit" placeholder="Tahun Terbit" inputmode="numeric" required>
        </div>
      </li>
    </ul>

    <div class="btn">
      <button class="simpan" type="submit" name="simpan" value="simpan">Simpan</button>
      <button type="reset" class="reset">Reset</button>
    </div>
  </form>
</div>