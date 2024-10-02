<?php
  session_name('user_session');
  session_start();

  unset($_SESSION['id_pengguna']);
  unset($_SESSION['nama_pengguna']);
  unset($_SESSION['gender']);
  unset($_SESSION['alamat']);
  unset($_SESSION['no_telp']);

  session_destroy();
  echo "<script>window.location.href = 'index.php'</script>";
?>