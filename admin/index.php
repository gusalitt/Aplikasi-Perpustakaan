<?php
include "../inc/connect.php";
session_name('admin_session');
session_start();

if (!(isset($_SESSION['nama_admin'])) || $_SESSION['nama_admin'] == '') {
  header('Location: login.php');
  exit;
}

// Mengatur active atau tidaknya sebuah elemen di menu sidebar.
function isActive($key_page1, $key_page2 = null, $key_page3 = null) {
  if (isset($_GET['page'])) {
    return $_GET['page'] == $key_page1 || $_GET['page'] == $key_page2 || $_GET['page'] == $key_page3 ? 'active' : ''; 
  }
  return '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perpustakaan</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/css/responsive.css">
  <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
  <?php 
    if (isset($_GET['page'])) {
      $page = $_GET['page'];

      if ($page == 'dasbhoard' || $page == '') {
        echo "<link rel='stylesheet' href='./assets/css/dasbhoard.css'>";
      } elseif ($page == 'tambah_buku' || $page == 'edit_buku' || $page == 'edit_admin') {
        echo "<link rel='stylesheet' href='./assets/css/tambah_buku.css'>";
      } elseif ($page == 'daftar_buku' || $page == 'daftar_pengguna' || $page == 'daftar_admin' || $page == 'peminjaman_buku' || $page == 'pengembalian_buku') {
        echo "<link rel='stylesheet' href='./assets/css/daftar.css'>";
      } elseif ($page == 'tambah_pengguna' || $page == 'edit_pengguna') {
        echo "<link rel='stylesheet' href='./assets/css/tambah_pengguna.css'>";
      } 
    } else {
      echo "<link rel='stylesheet' href='./assets/css/dasbhoard.css'>";
    }
  ?>
</head>
<body class="">
<div class="container">
    <nav class="sidebar">
      <h2><img src="./assets/img/pp.svg" alt=""><div><?= $_SESSION['nama_admin']; ?><span>Admin</span></div></h2>
      <ul>
        <li class="first-child"><a href="?page=dasbhoard" class="<?= isActive('dasbhoard'); ?>"><i class="fa-solid fa-chart-pie"></i> <span>Dasbhoard</span></a></li>
        <li><a href="" class="nav-link <?= isActive('tambah_buku', 'daftar_buku', 'edit_buku'); ?>"><i class="fa-solid fa-book"></i> <span>Manajemen Buku</span> <i class="fa-solid fa-chevron-down"></i></a>
          <ul>
            <li><a href="?page=tambah_buku" class="<?= isActive('tambah_buku'); ?>"><i class="fa-solid fa-circle-plus"></i> <span class="span-dropdown">Tambah Buku</span></a></li>
            <li><a href="?page=daftar_buku" class="<?= isActive('daftar_buku', 'edit_buku'); ?>"><i class="fa-solid fa-list"></i> <span class="span-dropdown">Daftar Buku</span></a></li>
          </ul>
        </li>
        <li><a href="" class="nav-link <?= isActive('tambah_pengguna', 'daftar_pengguna', 'edit_pengguna'); ?>"><i class="fa-solid fa-user"></i> <span>Manajemen Pengguna</span> <i class="fa-solid fa-chevron-down"></i></a>
          <ul>
            <li><a href="?page=tambah_pengguna" class="<?= isActive('tambah_pengguna'); ?>"><i class="fa-solid fa-user-plus"></i> <span class="span-dropdown">Tambah Pengguna</span></a></li>
            <li><a href="?page=daftar_pengguna" class="<?= isActive('daftar_pengguna', 'edit_pengguna'); ?>"><i class="fa-solid fa-users"></i> <span class="span-dropdown">Daftar Pengguna</span></a></li>
          </ul>
        </li>
        <li><a href="" class="nav-link <?= isActive('peminjaman_buku', 'pengembalian_buku'); ?>"><i class="fa-solid fa-book-open-reader"></i> <span>Peminjaman</span> <i class="fa-solid fa-chevron-down"></i></a>
          <ul>
            <li><a href="?page=peminjaman_buku" class="<?= isActive('peminjaman_buku'); ?>"><i class="fas fa-list-alt"></i> <span class="span-dropdown">Peminjaman Buku</span></a></li>
            <li><a href="?page=pengembalian_buku" class="<?= isActive('pengembalian_buku'); ?>"><i class="fas fa-undo"></i> <span class="span-dropdown">Pengembalian Buku</span></a></li>
          </ul>
        </li>
        <li class="last-child"><a href="?page=daftar_admin" class="<?= isActive('daftar_admin', 'edit_admin'); ?>"><i class="fa-solid fa-users-gear"></i> <span>Daftar Admin</span></a></li>
        <li id="signout"><a href="logout.php" onclick="return confirm('Apakah anda benar benar ingin keluar dari aplikasi ini?')"><i class="fa-solid fa-right-from-bracket"></i> <span>Logout</span></a></li>
      </ul>
    </nav> 

    <div class="main-container">
      <nav class="navbar">
        <ul>
          <li><span><i class="fa-solid fa-xmark"></i></span></li>
          <li id="title-nav"><span>APP Perpustakaan V 1.0</span></li>
          <li class="mode">
              <button class="dropbtn"><i class="fa-solid fa-sun"></i> <i class="fa-solid fa-caret-down"></i></button>
              <div class="dropdown-wrapper" id="dropdown-wrapper">
                <div class="dropdown-content">
                  <div>
                    <span class="light-mode active"><i class="fa-solid fa-sun"></i> Light</span>
                  </div>
                  <div>
                    <span class="dark-mode"><i class="fa-solid fa-moon"></i> Dark</span>
                  </div>
                </div>
              </div>
            </li>
        </ul>
      </nav>

      <section class="main">
        <div class="info-data">
          <p>Data Admin</p>
          <p><a href="?page=dasbhoard">Home</a> / Data Admin</p>
        </div>
        <?php
          if (isset($_GET['page']) && $_GET['page'] !== '') {
            $page = $_GET['page'];

            if ($page == 'dasbhoard' || $page == '' || empty($page)) {
              include "dasbhoard.php";
              echo "<script>document.querySelector('.info-data').style.display = 'none';
                document.querySelector('section.main').style.padding = '0';
              </script>";

            } elseif ($page == 'tambah_buku') {
              include "buku/tambah_buku.php";

            } elseif ($page == 'edit_buku') {
              include "buku/edit_buku.php";

            } elseif ($page == 'daftar_buku') {
              include "buku/daftar_buku.php";

            } elseif ($page == 'tambah_pengguna') {
              include "pengguna/tambah_pengguna.php";

            } elseif ($page == 'edit_pengguna') {
              include "pengguna/edit_pengguna.php";

            } elseif ($page == 'daftar_pengguna') {
              include "pengguna/daftar_pengguna.php";

            } elseif ($page == 'peminjaman_buku') {
              include "peminjaman/peminjaman_buku.php";

            } elseif ($page == 'pengembalian_buku') {
              include "peminjaman/pengembalian_buku.php";

            } elseif ($page == 'daftar_admin') {
              include "manajemen_admin/daftar_admin.php";

            } elseif ($page == 'edit_admin') {
              include "manajemen_admin/edit_admin.php";
  
            } elseif ($page == 'kelola_data') {
              include  "kelola_data.php";
              echo "<center><h1 style='font-weight: 100; font-size: 2rem; margin: 11rem 0; color: var(--text-color);'>Halaman tidak ditemukan...</h1></center>";
              echo "<script>document.querySelector('.info-data').style.display = 'none';
                document.querySelector('section.main').style.padding = '0';
              </script>";

            } else {
              echo "<center><h1 style='font-weight: 100; font-size: 2rem; margin: 11rem 0; color: var(--text-color);'>Halaman tidak ditemukan...</h1></center>";
              echo "<script>document.querySelector('.info-data').style.display = 'none';
                Array.from(document.querySelectorAll('nav.sidebar li a')).forEach(v => v.classList.remove('active'));
              </script>";
            }
          } elseif (!isset($_GET['page'])) {
            if (isset($_GET['action']) && $_GET['action'] != '') {
              $action = $_GET['action'];

              if ($action == 'print_buku') {
                include "buku/print_buku.php";

              } elseif ($action == 'print_pengguna') {
                include "pengguna/print_pengguna.php";

              } elseif ($action == 'print_peminjaman') {
                include "peminjaman/print_peminjaman.php";

              } elseif ($action == 'print_pengembalian') {
                include "peminjaman/print_pengembalian.php";

              } elseif ($action == 'print_admin') {
                include "manajemen_admin/print_admin.php";

              }

            } else {
              include  "dasbhoard.php";
              echo "<script>document.querySelector('.info-data').style.display = 'none';
                document.querySelector('section.main').style.padding = '0';
                document.querySelector('li.first-child a').classList.add('active');
              </script>";
            }
          } else {
            echo "<center><h1 style='font-weight: 100; font-size: 2rem; margin: 11rem 0; color: var(--text-color);'>Halaman tidak ditemukan...</h1></center>";
              echo "<script>document.querySelector('.info-data').style.display = 'none';
                Array.from(document.querySelectorAll('nav.sidebar li a')).forEach(v => v.classList.remove('active'));
              </script>";
          }
        ?>
      </section>
    </div>
  </div>
  

  <script src="assets/js/script.js"></script>
</body>
</html>