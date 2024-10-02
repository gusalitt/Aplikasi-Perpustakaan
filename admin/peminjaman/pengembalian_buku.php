  <main class="main-daftar daftar-pengembalian">
    <div class="container-daftar">
      <div class="head">
        <h1><i class="fas fa-undo"></i><span>Riwayat Pengembalian Buku</span></h1>
        <div class="search-box">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="search" name="search" id="search" placeholder="Cari buku yang dikembalikan..." >
        </div>
        <div class="btn">
          <a href="?action=print_pengembalian" id="printBtn2"><i class="fa-solid fa-print"></i> <span>Print Tabel</span></a>
          <button class="hapus"><i class="fa-solid fa-ellipsis-vertical"></i></button>
          <form action="?page=kelola_data" method="POST">
            <input type="hidden" name="table_pengembalian" value="pengembalian_buku" readonly style="display: none;">
            <button type="submit" class="hapus-semua" name="reset_pengembalian" onclick="return confirm('Apakah anda yakin ingin menghapus semua riwayat pengembalian buku ini?')">Hapus Semua</button>
          </form>
        </div>
      </div>
      <div class="table-container">
        <table class="table">
          <thead>
            <tr>
              <th>No</th>
              <th>Buku</th>
              <th>Peminjam</th>
              <th>Tgl Dikembalikan</th>
              <th>Terlambat</th>
              <th>Denda</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $sql = "SELECT pm.id_kembali, pm.id_buku, b.judul_buku, pm.id_pengguna, pg.nama_pengguna, pm.tgl_pengembalian, pm.terlambat, pm.denda
                      FROM pengembalian_buku pm
                      INNER JOIN buku b ON pm.id_buku = b.id_buku
                      INNER JOIN pengguna pg ON pm.id_pengguna = pg.id_pengguna";
              $stmt = $conn->prepare($sql);
              $stmt->execute();
              $result = $stmt->get_result();
              $no = 1;
              $data_pengembalian = [];
              
              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><span class="id-data"><?= htmlspecialchars($row['id_buku'])?></span> - <?= htmlspecialchars($row['judul_buku']); ?></td>
                    <td><span class="id-data"><?= htmlspecialchars($row['id_pengguna'])?></span> - <?= htmlspecialchars($row['nama_pengguna']); ?></td>
                    <td><?= date("d/M/Y", strtotime(htmlspecialchars($row['tgl_pengembalian']))); ?></td>
                    <td><?= htmlspecialchars($row['terlambat']) . " hari"; ?></td>
                    <td><?= "Rp. " . number_format(htmlspecialchars($row['denda']), 2, ',', '.'); ?></td>
                    <td>
                      <form action="?page=kelola_data" method="POST">
                        <input type="hidden" name="table_pengembalian" value="pengembalian_buku" readonly style="display: none;">
                        <button name="hapus_pengembalian" value="<?= htmlspecialchars($row['id_kembali']) ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data pengembalian buku ini?')" class="trash"><i class="fa-solid fa-trash"></i></button>
                      </form>
                    </td>
                  </tr>
              <?php 
                  $data_pengembalian[] = [
                    'id_buku' => $row['id_buku'],
                    'judul_buku' => $row['judul_buku'],
                    'id_pengguna' => $row['id_pengguna'],
                    'nama_pengguna' => $row['nama_pengguna'],
                    'tgl_pengembalian' => date("d/M/Y", strtotime($row['tgl_pengembalian'])),
                    'terlambat' => $row['terlambat'],
                    'denda' => $row['denda']
                  ];
                }
              } else {
              ?>
                  <tr>
                    <td class="data-kosong" colspan="7">Riwayat Pengembalian buku kosong...</td>
                  </tr>
              <?php 
              }
              $_SESSION['print_pengembalian'] = $data_pengembalian;
              $stmt->close();
              $conn->close();
              ?>
          </tbody>
        </table>
        <div class="info-denda">
          <p>Denda <span>Rp 2.000/hari</span> berlaku untuk pengembalian buku yang terlambat melebihi <span>7 hari</span> atau melewati batas waktu yang ditetapkan.</p>
        </div>
      </div>
    </div>
  </main>
