<?php
function get_amount($alias, $table) {
  global $conn;
  $sql = "SELECT COUNT(*) AS $alias FROM $table";
  $result = $conn->query($sql);

  $total = 0;
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total = $row[$alias];
  }
  return $total;
}

?>
  <div class="container-dasbhoard">
    <div class="title">
      <i class="fa-solid fa-chart-pie"></i>
      <h1>Dasbhoard Admin</h1>
    </div>
    <div class="box-wrapper">
      <div class="box redd">
        <p><i class="fa-solid fa-list"></i> Data Buku</p>
        <p><span><?= get_amount("jumlah_buku", "buku"); ?></span> Buku</p>
        <a href="?page=daftar_buku" class="info">View Details<i class="fa-solid fa-circle-arrow-right"></i></a>
      </div>
      <div class="box bluee">
        <p><i class="fa-solid fa-users"></i> Total Pengguna</p>
        <p><span><?= get_amount("jumlah_pengguna", "pengguna"); ?></span> Pengguna</p>
        <a href="?page=daftar_pengguna" class="info">View Details<i class="fa-solid fa-circle-arrow-right"></i>
        </a>
      </div>
      <div class="box greenn">
        <p><i class="fas fa-list-alt"></i> Pinjaman Buku</p>
        <p><span><?= get_amount("jumlah_pinjaman", "peminjaman_buku"); ?></span> Buku</p>
        <a href="?page=peminjaman_buku" class="info">View Details<i class="fa-solid fa-circle-arrow-right"></i>
        </a>
      </div>
      <div class="box yelloww">
        <p><i class="fa-solid fa-users-gear"></i> Daftar Admin</p>
        <p><span><?= get_amount("jumlah_admin", "admin"); ?></span> Admin</p>
        <a href="?page=daftar_admin" class="info">View Details<i class="fa-solid fa-circle-arrow-right"></i>
        </a>
      </div>
    </div>
  </div>

  <footer>
    <p>&copy; 2024 App Perpustakaan. Semua hak cipta dilindungi.</p>
  </footer>

