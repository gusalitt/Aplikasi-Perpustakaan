<?php 
  $_SESSION['template_pengguna'] = '';
?>

  <main class="main-daftar">
    <div class="container-daftar">
      <div class="head">
        <h1><i class="fa-solid fa-users"></i><span>Daftar Pengguna</span></h1>
        <div class="search-box">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="search" name="search" id="search" placeholder="Cari pengguna..." >
        </div>
        <div class="btn">
          <a href="?page=tambah_pengguna"><i class="fa-solid fa-plus"></i><span class="tpengguna">Tambah Pengguna</span></a>
          <a href="?action=print_pengguna" id="printBtn"><i class="fa-solid fa-print"></i> <span>Print Tabel</span></a>
          <button class="hapus"><i class="fa-solid fa-ellipsis-vertical"></i></button>
          <form action="?page=kelola_data" method="POST">
            <input type="hidden" name="table_pengguna" value="pengguna" readonly style="display: none;">
            <button type="submit" class="hapus-semua" name="reset_pengguna" onclick="return confirm('Apakah anda yakin ingin menghapus semua data pengguna ini?')">Hapus Semua</button>
          </form>
        </div>
      </div>
      <div class="table-container">
        <table class="table">
          <thead>
            <tr>
              <th>No</th>
              <th>ID Pengguna</th>
              <th>Nama Pengguna</th>
              <th>Jenis Kelamin</th>
              <th>Alamat</th>
              <th>No Hp</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $sql = "SELECT * FROM pengguna";
              $stmt = $conn->prepare($sql);
              $stmt->execute();
              $result = $stmt->get_result();
              $no = 1;
              $data_pengguna = [];

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['id_pengguna']); ?></td>
                    <td><?= htmlspecialchars($row['nama_pengguna']); ?></td>
                    <td><?= htmlspecialchars($row['jenis_kelamin']); ?></td>
                    <td><?= htmlspecialchars($row['alamat']); ?></td>
                    <td><?= htmlspecialchars($row['no_hp']); ?></td>
                    <td>
                      <div class="dropdown">
                        <button class="dropbtn"><i class="fa-solid fa-ellipsis"></i></button>
                        <div class="dropdown-content">
                          <form action="?page=kelola_data" method="POST">
                            <input type="hidden" name="table_pengguna" value="pengguna" readonly style="display: none;">
                            <button type="submit" name="editPengguna" value="<?= htmlspecialchars($row['id_pengguna']) ?>">Edit</button>
                            <button name="hapus_pengguna" value="<?= htmlspecialchars($row['id_pengguna']) ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data pengguna ini?')">Hapus</button>
                          </form>
                        </div>
                      </div>
                    </td>
                  </tr>
              <?php 
                  $data_pengguna[] = [
                    'id_pengguna' => $row['id_pengguna'],
                    'nama_pengguna' => $row['nama_pengguna'],
                    'jenis_kelamin' => $row['jenis_kelamin'],
                    'alamat' => $row['alamat'],
                    'no_hp' => $row['no_hp'],
                  ];
                }
              } else {
              ?>
                  <tr>
                    <td class="data-kosong" colspan="7">Data pengguna kosong...</td>
                  </tr>
              <?php 
              }
              $_SESSION['print_pengguna'] = $data_pengguna;
              $stmt->close();
              $conn->close();
              ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
  