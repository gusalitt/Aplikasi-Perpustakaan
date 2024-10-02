<?php
  if (isset($_GET['action']) && $_GET['action'] == 'print_buku') {
    $data_buku = $_SESSION['print_buku'] ?? [];
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
    <h1 style="text-align: center !important; margin: 1rem 0;">Data Buku App Perpustakaan</h1>
    <table border="1" cellpadding="10" cellspacing="0">
      <thead>
        <tr>
          <th>No</th>
          <th>ID Buku</th>
          <th>Judul Buku</th>
          <th>Pengarang</th>
          <th>Penerbit</th>
          <th>Tahun Terbit</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($data_buku as $row) { ?>
        <tr>
          <td><?= $no++; ?></td>
          <td><?= htmlspecialchars($row['id_buku']); ?></td>
          <td><?= htmlspecialchars($row['judul_buku']); ?></td>
          <td><?= htmlspecialchars($row['pengarang']); ?></td>
          <td><?= htmlspecialchars($row['penerbit']); ?></td>
          <td><?= htmlspecialchars($row['tahun_terbit']); ?></td>
        </tr>
      <?php } ?>
      </tbody>
    </table> 
  </div>

  <script>
    window.onload = function() {
      printBuku();
    };

    function printBuku() {
      window.print();
      setTimeout(() => {
        window.location.href = "?page=daftar_buku";
      }, 1000);
    }
  </script>

<?php
  }
?>
