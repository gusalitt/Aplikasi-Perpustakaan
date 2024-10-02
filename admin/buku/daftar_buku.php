<?php 
  $_SESSION['template_buku'] = '';
?>
  <main class="main-daftar">
    <div class="container-daftar">
      <div class="head">
        <h1><i class="fa-solid fa-list"></i><span>Daftar Buku</span></h1>
        <div class="search-box">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="search" name="search" id="search" placeholder="Cari buku..." >
        </div>
        <div class="btn">
          <a href="?page=tambah_buku"><i class="fa-solid fa-plus"></i><span>Tambah Buku</span></a>
          <a href="?action=print_buku" id="printBtn"><i class="fa-solid fa-print"></i> <span>Print Tabel</span></a>
          <button class="hapus"><i class="fa-solid fa-ellipsis-vertical"></i></button>
          <form action="?page=kelola_data" method="POST">
            <input type="hidden" name="table_buku" value="buku" readonly style="display: none;">
            <button type="submit" class="hapus-semua" name="reset_buku" onclick="return confirm('Apakah anda yakin ingin menghapus semua data buku ini?')">Hapus Semua</button>
          </form>
        </div>
      </div>
      <div class="table-container">
        <table class="table">
          <thead>
            <tr>
              <th>No</th>
              <th>ID Buku</th>
              <th>Judul Buku</th>
              <th>Pengarang</th>
              <th>Penerbit</th>
              <th>Tahun Terbit</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $sql = "SELECT * FROM buku";
              $stmt = $conn->prepare($sql);
              $stmt->execute();
              $result = $stmt->get_result();
              $no = 1;
              $data_buku = [];

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['id_buku']); ?></td>
                    <td><?= htmlspecialchars($row['judul_buku']); ?></td>
                    <td><?= htmlspecialchars($row['pengarang']); ?></td>
                    <td><?= htmlspecialchars($row['penerbit']); ?></td>
                    <td><?= htmlspecialchars($row['tahun_terbit']); ?></td>
                    <td>
                      <div class="dropdown">
                        <button class="dropbtn"><i class="fa-solid fa-ellipsis"></i></button>
                        <div class="dropdown-content">
                          <form action="?page=kelola_data" method="POST">
                            <input type="hidden" name="table_buku" value="buku" readonly style="display: none;">
                            <button type="submit" name="editBuku" value="<?= htmlspecialchars($row['id_buku']) ?>">Edit</button>
                            <button name="hapus_buku" value="<?= htmlspecialchars($row['id_buku']) ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data buku ini?')">Hapus</button>
                          </form>
                        </div>
                      </div>
                    </td>
                  </tr>

              <?php 
                  $data_buku[] = [
                    'id_buku' => $row['id_buku'],
                    'judul_buku' => $row['judul_buku'],
                    'pengarang' => $row['pengarang'],
                    'penerbit' => $row['penerbit'],
                    'tahun_terbit' => $row['tahun_terbit'],
                  ];
                }
              } else {
              ?>
                  <tr>
                    <td class="data-kosong" colspan="7">Data buku kosong...</td>
                  </tr>
              <?php 
              }
              $_SESSION['print_buku'] = $data_buku;
              $stmt->close();
              $conn->close();
              ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>