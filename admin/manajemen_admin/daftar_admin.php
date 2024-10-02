<?php
  $_SESSION['template_admin'] = '';
?>


<main class="main-daftar">
    <div class="container-daftar">
      <div class="head">
        <h1><i class="fa-solid fa-users-gear"></i><span>Daftar Admin</span></h1>
        <div class="search-box">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="search" name="search" id="search" placeholder="Cari admin..." >
        </div>
        <div class="btn">
          <a href="?action=print_admin" id="printBtn2"><i class="fa-solid fa-print"></i> <span>Print Tabel</span></a>
          <button class="hapus"><i class="fa-solid fa-ellipsis-vertical"></i></button>
          <form action="?page=kelola_data" method="POST">
            <input type="hidden" name="table_admin" value="admin" readonly style="display: none;">
            <button type="submit" class="hapus-semua" name="reset_admin" onclick="return confirm('Apakah anda yakin ingin menghapus semua data admin ini?')">Hapus Semua</button>
          </form>
        </div>
      </div>
      <div class="table-container">
        <table class="table">
          <thead>
            <tr>
              <th>No</th>
              <th>Username</th>
              <th>Email</th>
              <th>Level</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
              $sql = "SELECT * FROM admin";
              $stmt = $conn->prepare($sql);
              $stmt->execute();
              $result = $stmt->get_result();
              $no = 1;
              $data_admin = [];

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['username']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td>Admin</td>
                    <td>
                      <div class="dropdown">
                        <button class="dropbtn"><i class="fa-solid fa-ellipsis"></i></button>
                        <div class="dropdown-content">
                          <form action="?page=kelola_data" method="POST">
                            <input type="hidden" name="table_admin" value="admin" readonly style="display: none;">
                            <button type="submit" name="editAdmin" value="<?= htmlspecialchars($row['id_admin']) ?>">Edit</button>
                            <button name="hapus_admin" value="<?= htmlspecialchars($row['id_admin']) ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data admin ini?')">Hapus</button>
                          </form>
                        </div>
                      </div>
                    </td>
                  </tr>
              <?php 
                  $data_admin[] = [
                    'nama_admin' => $row['username'],
                    'email' => $row['email'],
                  ];
                }
              } else {
              ?>
                  <tr>
                    <td class="data-kosong" colspan="7">Data Admin kosong...</td>
                  </tr>
              <?php 
              }
              $_SESSION['print_admin'] = $data_admin;
              $stmt->close();
              $conn->close();
              ?>
          </tbody>
        </table>
      </div>
    </div>