<?php
  if (isset($_GET['action']) && $_GET['action'] == 'print_admin') {
    $data_admin = $_SESSION['print_admin'] ?? [];
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
    <h1 style="text-align: center !important; margin: 1rem 0;">Data Admin App Perpustakaan</h1>
    <table border="1" cellpadding="10" cellspacing="0">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Admin</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($data_admin as $row) { ?>
        <tr>
          <td><?= $no++; ?></td>
          <td><?= htmlspecialchars($row['nama_admin']); ?></td>
          <td><?= htmlspecialchars($row['email']); ?></td>
        </tr>
      <?php } ?>
      </tbody>
    </table> 
  </div>

  <script>
    window.onload = function() {
      printAdmin();
    };

    function printAdmin() {
      window.print();
      setTimeout(() => {
        window.location.href = "?page=daftar_admin";
      }, 1000);
    }
  </script>

<?php
  }
?>
