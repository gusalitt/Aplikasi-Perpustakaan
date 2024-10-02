<?php
  if (isset($_GET['action']) && $_GET['action'] == 'print_pengguna') {
    $data_pengguna = $_SESSION['print_pengguna'] ?? [];
    $no = 1;
?>
  <style>
    @media print {
      nav.sidebar, nav.navbar , section.main div.info-data {
        display: none;
      }

      #printTable {
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
        display: flex;
        justify-content: start;
        align-items: start;
        flex-direction: column;
      }
      div.main-container {
        width: 100%;
        left: 0;
      }
      #printTable table {
        width: 100%;
      }
      #printTable th, #printTable td {
        border: 1px solid #000;
        padding: 8px;
        color: #000;
      }
    }
  </style>

  <div id="printTable">
    <h1 style="text-align: center !important; margin: 1rem 0;">Data Pengguna App Perpustakaan</h1>
    <table border="1" cellpadding="10" cellspacing="0">
      <thead>
        <tr>
          <th>No</th>
          <th>ID Pengguna</th>
          <th>Nama Pengguna</th>
          <th>Gender</th>
          <th>Alamat</th>
          <th>No Telp</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($data_pengguna as $row) { ?>
        <tr>
          <td><?= $no++; ?></td>
          <td><?= htmlspecialchars($row['id_pengguna']); ?></td>
          <td><?= htmlspecialchars($row['nama_pengguna']); ?></td>
          <td><?= htmlspecialchars($row['jenis_kelamin']); ?></td>
          <td><?= htmlspecialchars($row['alamat']); ?></td>
          <td><?= htmlspecialchars($row['no_hp']); ?></td>
        </tr>
      <?php } ?>
      </tbody>
    </table> 
  </div>

  <script>
    window.onload = function() {
      printPengguna();
    };

    function printPengguna() {
      window.print();
      setTimeout(() => {
        window.location.href = "?page=daftar_pengguna";
      }, 1000);
    }
  </script>

<?php
  }
?>
