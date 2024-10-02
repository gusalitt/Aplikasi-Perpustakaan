<?php
  include "../inc/connect.php";

  function hapus_data($id_hapus, $table) {
    global $conn;

    switch ($table) {
      case "buku":
      case "pengguna":
        $query_peminjaman = "SELECT COUNT(*) AS count FROM peminjaman_buku WHERE id_$table = ?";
        $query_pengembalian = "SELECT COUNT(*) AS count FROM pengembalian_buku WHERE id_$table = ?";

        $stmt_peminjaman = $conn->prepare($query_peminjaman);
        $stmt_peminjaman->bind_param('s', $id_hapus);
        $stmt_peminjaman->execute();
        $result_peminjaman = $stmt_peminjaman->get_result();
        $row_peminjaman = $result_peminjaman->fetch_assoc();

        $stmt_pengembalian = $conn->prepare($query_pengembalian);
        $stmt_pengembalian->bind_param('s', $id_hapus);
        $stmt_pengembalian->execute();
        $result_pengembalian = $stmt_pengembalian->get_result();
        $row_pengembalian = $result_pengembalian->fetch_assoc();

        if ($row_peminjaman['count'] > 0 || $row_pengembalian['count'] > 0) {
          echo "<script>alert('Data tidak dapat dihapus karena masih terkait dengan data lain. Hapus data terkait terlebih dahulu.');</script>";
          echo "<script>window.location.href = '?page=daftar_$table';</script>";
          $stmt_peminjaman->close();
          $stmt_pengembalian->close();
        } else {
            $sql = "DELETE FROM $table WHERE id_$table = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('s', $id_hapus);

            if ($stmt->execute()) {
              echo "<script>alert('Data $table berhasil dihapus!');</script>";
              echo "<script>window.location.href = '?page=daftar_$table';</script>";
              $stmt->close();
              exit;
            } else {
              echo "<script>alert('Data $table gagal dihapus!');</script>";
            }
          }
        break;
      
      case "peminjaman_buku":
        $replace_str = str_replace("_",  " ", $table);
        $sql = "DELETE FROM $table WHERE id_pinjam = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $id_hapus);
    
        if ($stmt->execute()) {
          echo "<script>alert('Data $replace_str berhasil dihapus!');</script>";
          echo "<script>window.location.href = '?page=$table';</script>";
          $stmt->close();
          exit;
        } else {
          echo "<script>alert('Data $replace_str gagal dihapus!');</script>";
        }
        break;

      case "pengembalian_buku":
        $replace_str = str_replace("_",  " ", $table);
        $sql = "DELETE FROM $table WHERE id_kembali = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $id_hapus);
    
        if ($stmt->execute()) {
          echo "<script>alert('Data $replace_str berhasil dihapus!');</script>";
          echo "<script>window.location.href = '?page=$table';</script>";
          $stmt->close();
          exit;
        } else {
          echo "<script>alert('Data $replace_str gagal dihapus!');</script>";
        }
        break;
      
      case "admin":
        $sql = "DELETE FROM admin WHERE id_admin = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $id_hapus);
        
        if ($stmt->execute()) {
          $sisa_sql = "SELECT COUNT(*) AS sisa_admin FROM admin";
          $result = $conn->query($sisa_sql);
          $row = $result->fetch_assoc();
        
          if ($row['sisa_admin'] == 0) {
            echo "<script>alert('Semua admin telah dihapus, sesi akan dihentikan.');</script>";
            session_destroy();
          } else {
            echo "<script>alert('Data admin berhasil dihapus!');</script>";
          }
          echo "<script>window.location.href = '?page=daftar_admin';</script>";
          exit;
        } else {
          echo "<script>alert('Data admin gagal dihapus!');</script>";
        }
        $stmt->close();
        break;

      default:
        echo "<script>alert('Ada kesalahan!. Mohon coba lagi...');</script>";
        echo "<script>window.location.href = '?page=dasbhoard';</script>";
        return;
    }

    $conn->close();
  }

  function edit_data($id_edit, $table) {
    global $conn;

    if ($table == 'buku' || $table == 'pengguna' || $table == 'admin') {
      $sql = "SELECT * FROM $table WHERE id_$table = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param('s', $id_edit);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = [];
  
      if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION["template_$table"] = $row;
        echo "<script>window.location.href = '?page=edit_$table';</script>";
        exit;
        $stmt->close();
      }
    } else {
      echo "<script>alert('Ada kesalahan!. Mohon coba lagi...');</script>";
      echo "<script>window.location.href = '?page=dasbhoard';</script>";
      return;
    }

    $conn->close();
  }

  function reset_data($table) {
    global $conn;

    if ($table == 'buku' || $table == 'pengguna') {

      $query_peminjaman = "SELECT COUNT(*) AS count FROM peminjaman_buku";
      $query_pengembalian = "SELECT COUNT(*) AS count FROM pengembalian_buku";

      $stmt_peminjaman = $conn->prepare($query_peminjaman);
      $stmt_peminjaman->execute();
      $result_peminjaman = $stmt_peminjaman->get_result();
      $row_peminjaman = $result_peminjaman->fetch_assoc();

      $stmt_pengembalian = $conn->prepare($query_pengembalian);
      $stmt_pengembalian->execute();
      $result_pengembalian = $stmt_pengembalian->get_result();
      $row_pengembalian = $result_pengembalian->fetch_assoc();

      if ($row_peminjaman['count'] > 0 || $row_pengembalian['count'] > 0) {
        echo "<script>alert('Data tidak dapat dihapus karena masih terkait dengan data lain. Hapus data terkait terlebih dahulu.');</script>";
        echo "<script>window.location.href = '?page=daftar_$table';</script>";
        $stmt_peminjaman->close();
        $stmt_pengembalian->close();
      } else {
        $sql = "DELETE FROM $table";
        $stmt = $conn->prepare($sql);
    
        if ($stmt->execute()) {
          echo "<script>alert('Semua data $table berhasil dihapus!');</script>";
          echo "<script>window.location.href = '?page=daftar_$table';</script>";
          $stmt->close();
          exit;
        } else {
          echo "<script>alert('Semua data $table gagal dihapus!');</script>";
        }
      }

    } elseif ($table == 'admin') {
      $sql = "TRUNCATE TABLE admin";
      $stmt = $conn->prepare($sql);

      if ($stmt->execute()) {
        echo "<script>alert('Semua data admin berhasil dihapus!,  sesi akan dihentikan.');</script>";
        echo "<script>window.location.href = '?page=daftar_admin';</script>";
        session_destroy();
      } else {
        echo "<script>alert('Semua data admin gagal dihapus!');</script>";
      }
      $stmt->close();
      exit;

    } elseif ($table == 'peminjaman_buku' || $table == 'pengembalian_buku') {
      $replace_str = str_replace("_",  " ", $table);
      $sql = "TRUNCATE TABLE $table";
      $stmt = $conn->prepare($sql);
  
      if ($stmt->execute()) {
        echo "<script>alert('Semua data $replace_str berhasil dihapus!');</script>";
        echo "<script>window.location.href = '?page=$table';</script>";
        $stmt->close();
        exit;
      } else {
        echo "<script>alert('Semua data $replace_str gagal dihapus!');</script>";
      }

    } else {
      echo "<script>alert('Ada kesalahan!. Mohon coba lagi...');</script>";
      echo "<script>window.location.href = '?page=dasbhoard';</script>";
      return;
    }

    $conn->close();
  }

  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $actions = [
      'hapus_buku' => 'table_buku',
      'hapus_pengguna' => 'table_pengguna',
      'hapus_admin' => 'table_admin',
      'hapus_peminjaman' => 'table_peminjaman',
      'hapus_pengembalian' => 'table_pengembalian',
      'editBuku' => 'table_buku',
      'editPengguna' => 'table_pengguna',
      'editAdmin' => 'table_admin',
      'reset_buku' => 'table_buku',
      'reset_pengguna' => 'table_pengguna',
      'reset_admin' => 'table_admin',
      'reset_peminjaman' => 'table_peminjaman',
      'reset_pengembalian' => 'table_pengembalian'
    ];

    foreach ($actions as $action => $table) {
      if (isset($_POST[$action]) && isset($_POST[$table])) {
        if (strpos($action, 'hapus') !== false) {
          hapus_data($_POST[$action], $_POST[$table]);
        } elseif (strpos($action, 'edit') !== false) {
          edit_data($_POST[$action], $_POST[$table]);
        } elseif (strpos($action, 'reset') !== false) {
          reset_data($_POST[$table]);
        }
        break;
      }
    }
  }
?>