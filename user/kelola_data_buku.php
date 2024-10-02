<?php

  function pinjam_buku($id_buku, $id_pengguna) {
    global $conn;

    // Buat data var untuk dimasukkan ke table di database.
    $tgl_peminjaman = date('Y-m-d');
    $batas_waktu = date('Y-m-d' , (strtotime($tgl_peminjaman) + (60 * 60 * 24 * 7))); 
    $status = 'Dipinjam';

    // Validasi data id buku dan id pengguna.
    if (!(validasi_buku($id_buku, $id_pengguna))) {
      return;
    } 

    // Cek apakah buku sudah ada di table peminjaman buku.
    $cek_buku = $conn->prepare("SELECT id_buku, id_pengguna FROM peminjaman_buku WHERE id_buku = ? AND id_pengguna = ? AND status != 'Dikembalikan'");
    $cek_buku->bind_param('ss', $id_buku, $id_pengguna);
    $cek_buku->execute();
    $result = $cek_buku->get_result();
    $redirect = isset($_SESSION['page_redirect']) ? $_SESSION['page_redirect'] : 'index.php';

    if ($result->num_rows > 0) {
      echo "<script>alert('Buku tersebut sudah dipinjam!');</script>";
      echo "<script>window.location.href = '$redirect';</script>";
      unset($_SESSION['page_redirect']);
      $cek_buku->close();
      return;
      exit;
    } else {
      // Menambahkan data buku ke table peminjaman buku.
      $sql = "INSERT INTO peminjaman_buku (id_buku, id_pengguna, tgl_peminjaman, batas_waktu, status) VALUES (?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param('sssss', $id_buku, $id_pengguna, $tgl_peminjaman, $batas_waktu, $status);

      if ($stmt->execute()) {
        echo "<script>alert('Berhasil meminjam buku!');</script>";
        echo "<script>window.location.href = '$redirect';</script>";
        unset($_SESSION['page_redirect']);
        $stmt->close();
        return;
        exit;
      } else {
        echo "<script>alert('Gagal meminjam buku!');</script>";
        echo "<script>window.location.href = '$redirect';</script>";
        unset($_SESSION['page_redirect']);
        return;
        exit;
      }
    }
    $conn->close();
  }

  function kembalikan_buku($id_buku, $id_kembalikan, $id_pengguna) {
    global $conn;

    // Validasi data id buku dan id pengguna.
    if (!(validasi_buku($id_buku, $id_pengguna))) {
      return;
    } 

    // Cek apakah buku sudah ada di tabel peminjaman buku.
    $cek_pinjamanBuku = $conn->prepare("SELECT id_buku, id_pengguna, tgl_peminjaman, batas_waktu FROM peminjaman_buku WHERE id_buku = ? AND id_pengguna = ? AND id_pinjam = ?");
    $cek_pinjamanBuku->bind_param('sss', $id_buku, $id_pengguna, $id_kembalikan);
    $cek_pinjamanBuku->execute();
    $result = $cek_pinjamanBuku->get_result();
    $redirect = isset($_SESSION['page_redirect']) ? $_SESSION['page_redirect'] : 'index.php';


    if ($result->num_rows == 0) {
      echo "<script>alert('Buku tersebut belum dipinjam!');</script>";
      echo "<script>window.location.href = '$redirect';</script>";
      unset($_SESSION['page_redirect']);
      $cek_pinjamanBuku->close();
      return;
      exit;
    }

    $row = $result->fetch_assoc();
    if ($row['status'] == 'Dikembalikan') {
      echo "<script>alert('Buku tersebut sudah dikembalikan!');</script>";
      echo "<script>window.location.href = '$redirect';</script>";
      unset($_SESSION['page_redirect']);
      return;
      exit;
    }

    // Update status di tabel peminjaman buku menjadi 'Dikembalikan'.
    $update_status = $conn->prepare("UPDATE peminjaman_buku SET status = 'Dikembalikan' WHERE id_buku = ? AND id_pengguna = ? AND id_pinjam = ?");
    $update_status->bind_param('sss', $id_buku, $id_pengguna, $id_kembalikan);
    $update_status->execute();
    $update_status->close();

    // Menambahkan data buku yang dipinjam ke table pengembalian buku admin.
    $tgl_pengembalian = date('Y-m-d');
    $hari_terlambat = max(0, ceil((strtotime($tgl_pengembalian) - strtotime($row['batas_waktu'])) / (60 * 60 * 24)));
    $denda = $hari_terlambat * 2000;

    $sql = "INSERT INTO pengembalian_buku (id_buku, id_pengguna, tgl_pengembalian, terlambat, denda) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssss', $id_buku, $id_pengguna, $tgl_pengembalian, $hari_terlambat, $denda);
    $stmt->execute();
    $stmt->close();

    // Membuat table user_pengembalian_buku lebih akurat, yakni hanya jika ada data id_buku dan id_pengguna di tabel pengembalian_buku admin baru table user_pengembalian_buku bisa di insert dan update data baru yang sesuai.
    $user_loop_sql = "SELECT * FROM pengembalian_buku WHERE id_buku = ? AND id_pengguna = ?";
    $user_loop_stmt = $conn->prepare($user_loop_sql);
    $user_loop_stmt->bind_param('ss', $id_buku, $id_pengguna);
    $user_loop_stmt->execute();
    $result = $user_loop_stmt->get_result();
    
    // Mengupdate tabel user_pengembalian_buku
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        // Cek apakah ada data buku dengan id_buku dan id_pengguna yang sudah aktif di tabel user_pengembalian_buku (deleted = 0).
        $user_check_sql = "SELECT id_buku FROM user_pengembalian_buku WHERE id_buku = ? AND id_pengguna = ? AND deleted = 0";
        $check_user_stmt = $conn->prepare($user_check_sql);
        $check_user_stmt->bind_param('ss', $row['id_buku'], $_SESSION['id_pengguna']);
        $check_user_stmt->execute();
        $check_user_result = $check_user_stmt->get_result();

        if ($check_user_result->num_rows > 0) {
          // Update data jika ada ditemukan. Berfungsi untuk mencegah data duplikat di riwayat pengembalian buku user.
          $update_sql = "UPDATE user_pengembalian_buku SET tgl_pengembalian = ?, terlambat = ?, denda = ? WHERE id_buku = ? AND id_pengguna = ? AND deleted = 0";
          $update_stmt = $conn->prepare($update_sql);
          $update_stmt->bind_param('sssss', $row['tgl_pengembalian'], $row['terlambat'], $row['denda'], $row['id_buku'], $_SESSION['id_pengguna']);
          $update_stmt->execute();
          $update_stmt->close();

        } else {
          // Cek apakah ada data buku dengan id_buku sudah dihapus di tabel user_pengembalian_buku (deleted = 1).
          $deleted_check_sql = "SELECT id_buku FROM user_pengembalian_buku WHERE id_buku = ? AND id_pengguna = ? AND deleted = 1";
          $deleted_user_stmt = $conn->prepare($deleted_check_sql);
          $deleted_user_stmt->bind_param('ss', $row['id_buku'], $_SESSION['id_pengguna']);
          $deleted_user_stmt->execute();
          $deleted_user_result = $deleted_user_stmt->get_result();

          if ($deleted_user_result->num_rows > 0) {
            // Update data jika ada ditemukan.
            $update_sql = "UPDATE user_pengembalian_buku SET tgl_pengembalian = ?, terlambat = ?, denda = ?, deleted = 0 WHERE id_buku = ? AND id_pengguna = ? AND deleted = 1";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param('sssss', $row['tgl_pengembalian'], $row['terlambat'], $row['denda'], $row['id_buku'], $_SESSION['id_pengguna']);
            $update_stmt->execute();
            $update_stmt->close();
          } else {
            // Jika tidak ada data buku yang sama maka tambahkan data baru ke tabel user_pengembalian_buku.
            $deleted = 0;
            $insert_sql = "INSERT INTO user_pengembalian_buku (id_buku, id_pengguna, tgl_pengembalian, terlambat, denda, deleted) VALUES (?, ?, ?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param('sssssi', $row['id_buku'], $_SESSION['id_pengguna'], $row['tgl_pengembalian'], $row['terlambat'], $row['denda'], $deleted);
            $insert_stmt->execute();
            $insert_stmt->close();
          }
          $deleted_user_stmt->close();
        }
        $check_user_stmt->close();
      }
    }

    $user_loop_stmt->close();
    echo "<script>alert('Berhasil mengembalikan buku!');</script>";
    echo "<script>window.location.href = '$redirect';</script>";
    unset($_SESSION['page_redirect']);
    $conn->close();
    exit;
  }

  function validasi_buku($id_buku, $id_pengguna) {
    global $conn;

    // Cek apakah id_buku ada di tabel buku
    $cek_IdBuku = $conn->prepare("SELECT id_buku FROM buku WHERE id_buku = ?");
    $cek_IdBuku->bind_param('s', $id_buku);
    $cek_IdBuku->execute();
    $result = $cek_IdBuku->get_result();
    $redirect = isset($_SESSION['page_redirect']) ? $_SESSION['page_redirect'] : 'index.php';
    
    if ($result->num_rows == 0) {
      echo "<script>alert('Ada kesalahan terhadap data buku! Mohon coba lagi...');</script>";
      echo "<script>window.location.href = '$redirect';</script>";
      unset($_SESSION['page_redirect']);
      $cek_IdBuku->close();
      return false;
      exit;
    }
    
    // Cek apakah id_pengguna ada di tabel pengguna
    $cek_IdPengguna = $conn->prepare("SELECT id_pengguna FROM pengguna WHERE id_pengguna = ?");
    $cek_IdPengguna->bind_param('s', $id_pengguna);
    $cek_IdPengguna->execute();
    $result = $cek_IdPengguna->get_result();
    
    if ($result->num_rows == 0) {
      echo "<script>alert('Ada kesalahan terhadap data pengguna! Mohon coba lagi...');</script>";
      echo "<script>window.location.href = '$redirect';</script>";
      unset($_SESSION['page_redirect']);
      $cek_IdPengguna->close();
      return false;
      exit;
    } 

    $cek_IdBuku->close();
    $cek_IdPengguna->close();
    return true;
    $conn->close();
  }


  if (!(isset($_POST['id_buku'])) && !(isset($_POST['id_pengguna']))) {
    $redirect = isset($_SESSION['page_redirect']) ? $_SESSION['page_redirect'] : 'index.php';
    header("Location: $redirect");
    unset($_SESSION['page_redirect']);
    exit;
  } else {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      if (isset($_POST['id_pinjam']) && isset($_POST['id_pengguna'])) {
        pinjam_buku($_POST['id_pinjam'], $_POST['id_pengguna']);
      } elseif (isset($_POST['id_buku']) && isset($_POST['id_kembalikan']) && isset($_POST['id_pengguna'])) {
        kembalikan_buku($_POST['id_buku'], $_POST['id_kembalikan'], $_POST['id_pengguna']);
      }
    }
  }

?>