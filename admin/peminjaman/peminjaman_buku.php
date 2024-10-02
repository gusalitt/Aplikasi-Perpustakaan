  <main class="main-daftar">
    <div class="container-daftar">
      <div class="head">
        <h1><i class="fas fa-list-alt"></i><span>Riwayat Peminjaman Buku</span></h1>
        <div class="search-box">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="search" name="search" id="search" placeholder="Cari buku yang dipinjam..." >
        </div>
        <div class="btn">
          <a href="?action=print_peminjaman" id="printBtn2"><i class="fa-solid fa-print"></i> <span>Print Tabel</span></a>
          <button class="hapus"><i class="fa-solid fa-ellipsis-vertical"></i></button>
          <form action="?page=kelola_data" method="POST">
            <input type="hidden" name="table_peminjaman" value="peminjaman_buku" readonly style="display: none;">
            <button type="submit" class="hapus-semua" name="reset_peminjaman" onclick="return confirm('Apakah anda yakin ingin menghapus semua riwayat peminjaman buku ini?')">Hapus Semua</button>
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
              <th>Tgl Peminjaman</th>
              <th>Batas Waktu</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $sql = "SELECT pm.id_pinjam, pm.id_buku, b.judul_buku, pm.id_pengguna, pg.nama_pengguna, pm.tgl_peminjaman, pm.batas_waktu, pm.status
                      FROM peminjaman_buku pm
                      INNER JOIN buku b ON pm.id_buku = b.id_buku
                      INNER JOIN pengguna pg ON pm.id_pengguna = pg.id_pengguna";
              $stmt = $conn->prepare($sql);
              $stmt->execute();
              $result = $stmt->get_result();
              $no = 1;
              $data_peminjaman = [];

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><span class="id-data"><?= htmlspecialchars($row['id_buku'])?></span> - <?=htmlspecialchars($row['judul_buku']); ?></td>
                    <td><span class="id-data"><?= htmlspecialchars($row['id_pengguna'])?></span> - <?= htmlspecialchars($row['nama_pengguna']); ?></td>
                    <td><?= date("d/M/Y", strtotime(htmlspecialchars($row['tgl_peminjaman']))); ?></td>
                    <td><?= date("d/M/Y", strtotime(htmlspecialchars($row['batas_waktu']))); ?></td>
                    <td><?= htmlspecialchars($row['status']); ?></td>
                    <td>
                      <form action="?page=kelola_data" method="POST">
                        <input type="hidden" name="table_peminjaman" value="peminjaman_buku" readonly style="display: none;">
                        <button name="hapus_peminjaman" value="<?= htmlspecialchars($row['id_pinjam']) ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data peminjaman buku ini?')" class="trash"><i class="fa-solid fa-trash"></i></button>
                      </form>
                    </td>
                  </tr>
              <?php 
                  $data_peminjaman[] = [
                    'id_buku' => $row['id_buku'],
                    'judul_buku' => $row['judul_buku'],
                    'id_pengguna' => $row['id_pengguna'],
                    'nama_pengguna' => $row['nama_pengguna'],
                    'tgl_peminjaman' => date("d/M/Y", strtotime($row['tgl_peminjaman'])),
                    'batas_waktu' => date("d/M/Y", strtotime($row['batas_waktu'])),
                    'status' => $row['status']
                  ];
                } 
              } else {
              ?>
                  <tr>
                    <td class="data-kosong" colspan="7">Riwayat Peminjaman buku kosong...</td>
                  </tr>
              <?php 
              }
              $_SESSION['print_peminjaman'] = $data_peminjaman;
              $stmt->close();
              $conn->close();
              ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
