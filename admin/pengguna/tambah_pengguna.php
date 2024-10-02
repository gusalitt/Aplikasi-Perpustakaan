<?php
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


// Memasukkan data pengguna ke database. 
if (isset($_POST['simpan'])) {
  $idPengguna = trim($_POST['idPengguna']);
  $namaPengguna = trim($_POST['namaPengguna']);
  $password = trim($_POST['password']);
  $jKelamin = trim($_POST['jKelamin']);
  $alamat = trim($_POST['alamat']);
  $noHp = trim($_POST['noHp']);

  if (empty($idPengguna) || empty($namaPengguna) || empty($jKelamin) || empty($alamat) || empty($noHp) || empty($password)) {
    echo "<script>alert('Harap isi semua bidang input!');</script>";
  } else {
      $cek_sql = "SELECT * FROM pengguna WHERE nama_pengguna = ?  OR no_hp = ? ";
      $stmt = $conn->prepare($cek_sql);
      $stmt->bind_param('ss', $namaPengguna, $noHp);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        echo "<script>alert('Data pengguna tersebut telah terdaftar!')</script>";
      } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO pengguna (id_pengguna, nama_pengguna, jenis_kelamin, alamat, no_hp, password ) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssss', $idPengguna, $namaPengguna, $jKelamin, $alamat, $noHp, $password);
        if ($stmt->execute()) {
          echo "<script>alert('Data pengguna berhasil ditambah!');</script>";
        } else {
          echo "<script>alert('Data pengguna gagal ditambah');</script>";
        }
        echo "<script>window.location.href = '?page=daftar_pengguna';</script>";
        $stmt->close();
        exit;
      } 
    }
  }
$conn->close();
?>


<div class="tPenggunaWrapper">
  <h1><i class="fa-solid fa-user-plus"></i> <span>Tambah Pengguna</span></h1>

  <form action="" method="POST">
    <ul>
      <li>
        <div class="box-label">
          <label for="idPengguna">ID pengguna </label>
        </div>
        <span>:</span>
        <div class="box-input">
          <input type="text" name="idPengguna" id="idPengguna" value="<?= $new_ID; ?>" readonly>
        </div>
      </li>
      <li>
        <div class="box-label">
          <label for="namaPengguna">Nama Pengguna </label>
        </div>
        <span>:</span>
        <div class="box-input">
          <input type="text" name="namaPengguna" id="namaPengguna" placeholder="Nama Pengguna" required>
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
          <label for="jKelamin">Jenis Kelamin </label>
        </div>
        <span>:</span>
        <div class="box-input">
          <select type="text" name="jKelamin" id="jKelamin" required>
            <option value="" disabled selected>--Pilih--</option>
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
          <label for="noHp">No HP</label>
        </div>
        <span>:</span>
        <div class="box-input">
          <input type="tel" name="noHp" id="noHp" placeholder="No HP" inputmode="numeric" required>
        </div>
      </li>
    </ul>
  
    <div class="btn">
      <button class="simpan" type="submit"  name="simpan" value="simpan">Simpan</button>
      <button type="reset" class="reset">Reset</button>
    </div>
  </form>
</div>