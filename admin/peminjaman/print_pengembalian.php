<?php
  if (isset($_GET['action']) && $_GET['action'] == 'print_pengembalian') {
    $data_pengembalian = $_SESSION['print_pengembalian'] ?? [];
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
    <h1 style="text-align: center !important; margin: 1rem 0;">Data Pengembalian Buku App Perpustakaan</h1>
    <table border="1" cellpadding="10" cellspacing="0">
      <thead>
        <tr>
          <th>No</th>
          <th>Buku</th>
          <th>Peminjam</th>
          <th>Tgl Dikembalikan</th>
          <th>Terlambat</th>
          <th>Denda</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($data_pengembalian as $row) { ?>
        <tr>
          <td><?= $no++; ?></td>
          <td><?= htmlspecialchars($row['id_buku']) ." - ". htmlspecialchars($row['judul_buku']); ?></td>
          <td><?= htmlspecialchars($row['id_pengguna']) ." - ". htmlspecialchars($row['nama_pengguna']); ?></td>
          <td><?= htmlspecialchars($row['tgl_pengembalian']); ?></td>
          <td><?= htmlspecialchars($row['terlambat']) ." hari"; ?></td>
          <td><?= "Rp. " . number_format(htmlspecialchars($row['denda']), 2, ',', '.'); ?></td>
        </tr>
      <?php } ?>
      </tbody>
    </table> 
  </div>

  <script>
    window.onload = function() {
      printPengembalian();
    };

    function printPengembalian() {
      window.print();
      setTimeout(() => {
        window.location.href = "?page=pengembalian_buku";
      }, 1000);
    }
  </script>

<?php
  }
?>
