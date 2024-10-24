<?php 
  include "../inc/connect.php";
  session_name('user_session');
  session_start();

  // Mengatur halaman apa saja yang tidak boleh di redirect.
  $not_redirect = ['login_user.php', 'daftar_user.php', 'detail_buku', 'kelola_data_buku', 'detail_pinjaman', 'detail_pengembalian'];
  $should_redirect = true;

  foreach($not_redirect as $page) {
    if (strpos($_SERVER['REQUEST_URI'], $page) !== false) {
      $should_redirect = false;
      break;
    }
  }
  if ($should_redirect) {
    $_SESSION['page_redirect'] = $_SERVER['REQUEST_URI'];
  }

  // Mengatur bagian menu "Panduan Pengguna" di footer.
  $scrollToQuestion = isset($_GET['page']);

  // Mengatur active atau tidak nya suatu menu navbar.
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
  <link rel="shortcut icon" href="assets/img/favicon.png" type="image/x-icon">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel='stylesheet' href='assets/css/home.css'>
  <link rel="stylesheet" href="assets/css/responsive.css">
  <?php 
    if (isset($_GET['page'])) {
      $page = $_GET['page'];

      if ($page == 'koleksi_buku') {
        echo "<link rel='stylesheet' href='assets/css/koleksi_buku.css'>";
      } elseif ($page == 'tentang_kami') {
        echo "<link rel='stylesheet' href='assets/css/tentang_kami.css'>";
      } elseif ($page == 'profil') {
        echo "<link rel='stylesheet' href='assets/css/profil.css'>";
      } elseif ($page == 'detail_buku' || $page == 'detail_pinjaman' || $page == 'detail_pengembalian') {
        echo "<link rel='stylesheet' href='assets/css/detail_buku.css'>";
      }
    }
  ?>
</head>
<body>
  <header>
    <nav>
      <div class="logo">
        <img src="assets/img/favicon2.png" alt="logo perpustakaan">
        <h2>App Perpustakaan</h2> 
      </div>
      <ul class="nav-links">
        <li><a href="?page=home" class="<?= isActive('home'); ?>">Home</a></li>
        <li><a href="?page=koleksi_buku" class="<?= isActive('koleksi_buku'); ?>">Koleksi Buku</a></li>
        <li><a href="?page=tentang_kami" class="<?= isActive('tentang_kami'); ?>">Tentang Kami</a></li>
      </ul>
      <div class="box-dropdown">
        <div class="avatar-dropdown">
          <?php
            if (!(isset($_SESSION['nama_pengguna']))) {
              ?>
              <div class="link">
                <a href="login_user.php" class="login">Login</a>
                <a href="daftar_user.php" class="daftar">Daftar</a>
              </div>
            <?php
            } else {
            ?>
            <div class="dropbtn"> 
              <img src="assets/img/pp.svg" alt="User Avatar">
              <span class="user-name"><?= $_SESSION['nama_pengguna'] ?? 'Isi Data Diri'; ?></span>
              <span class="user-name icon"><i class="fa fa-caret-down"></i></span>
            </div>
            <div class="dropdown-content">
              <a href="?page=profil"><i class="fa-solid fa-user"></i> Lihat Profil</a>
              <a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
            </div>
            <?php
            }
          ?>

        </div>
        <div class="mode">
          <button class="dropbtn"><i class="fa-solid fa-sun"></i> <i class="fa-solid fa-caret-down"></i></button>
          <div class="dropdown-wrapper" id="dropdown-wrapper">
            <div class="dropdown-content">
              <div>
                <span class="light-mode"><i class="fa-solid fa-sun"></i> Light</span>
              </div>
              <div>
                <span class="dark-mode"><i class="fa-solid fa-moon"></i> Dark</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <ul class="mid-links">
        <li><a href="?page=home" class="<?= isActive('home'); ?>">Home</a></li>
        <li><a href="?page=koleksi_buku" class="<?= isActive('koleksi_buku'); ?>">Koleksi Buku</a></li>
        <li><a href="?page=tentang_kami" class="<?= isActive('tentang_kami'); ?>">Tentang Kami</a></li>
        <div class="box-dropdown">
          <div class="mid-avatar-dropdown">
            <?php
              if (!(isset($_SESSION['nama_pengguna']))) {
                ?>
                <div class="link">
                  <a href="login_user.php" class="login">Login</a>
                  <a href="daftar_user.php" class="daftar">Daftar</a>
                </div>
              <?php
              } else {
              ?>
              <div class="mid-dropbtn"> 
                <img src="assets/img/pp.svg" alt="User Avatar">
                <span class="user-name"><?= $_SESSION['nama_pengguna'] ?? 'Isi Data Diri'; ?></span>
                <span class="user-name icon"><i class="fa fa-caret-down"></i></span>
              </div>
              <div class="dropdown-content">
                <a href="?page=profil"><i class="fa-solid fa-user"></i> Lihat Profil</a>
                <a href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a>
              </div>
              <?php
              }
            ?>
  
          </div>
          <div class="mode">
            <button class="dropbtn mid-mode-dropbtn"><i class="fa-solid fa-sun"></i> <i class="fa-solid fa-caret-down"></i></button>
            <div class="dropdown-wrapper" id="dropdown-wrapper">
              <div class="dropdown-content">
                <div>
                  <span class="light-mode" id="light-mode"><i class="fa-solid fa-sun"></i> Light</span>
                </div>
                <div>
                  <span class="dark-mode" id="dark-mode"><i class="fa-solid fa-moon"></i> Dark</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </ul>
      <div class="hamburger-menu" id="hamburger-menu">
        <i class="fa fa-bars"></i>
      </div>
    </nav>
  </header>


    <main>
      <div class="main-content">
        <?php 
          if (isset($_GET['page']) && $_GET['page'] !== '') {
            $page = $_GET['page'];
            
            if ($page == 'home'|| $page == '' || empty($page)) {
              include "home/home.php";
            } elseif ($page == 'koleksi_buku') {
              include "koleksi_buku/koleksi_buku.php";
            } elseif ($page == 'tentang_kami') {
              include "tentang_kami/tentang_kami.php";
            } elseif ($page == 'profil') {
              include "profil/profil.php";
            } elseif ($page == 'detail_buku') {
              include "koleksi_buku/detail_buku.php";
            } elseif ($page == 'detail_pinjaman') {
              include "profil/detail_pinjaman.php";
            } elseif ($page == 'detail_pengembalian') {
              include "profil/detail_pengembalian.php";
            } elseif ($page == 'kelola_data_buku') {
              include "kelola_data_buku.php";
            } else {
              include "home/home.php";
              echo "<script>
                      Array.from(document.querySelectorAll('header nav li a')).forEach(v => v.classList.remove('active'))
                      document.querySelector('header li:first-child a').classList.add('active');
                    </script>";
            }
          } elseif (!isset($_GET['page'])) {
            include "home/home.php";
            echo "<script>
                    Array.from(document.querySelectorAll('header nav li a')).forEach(v => v.classList.remove('active'))
                    document.querySelector('header li:first-child a').classList.add('active');
                  </script>";
          } else {
            include "home/home.php";
            echo "<script>
                    Array.from(document.querySelectorAll('header nav li a')).forEach(v => v.classList.remove('active'))
                    document.querySelector('header li:first-child a').classList.add('active');
                  </script>";
          }
        ?>
        
      </div>
    </main>

    
  <footer>
    <div class="footer-container">
      <div class="footer-section info">
        <div class="logo">
          <img src="assets/img/favicon.png" alt="">
          App Perpustakaan
        </div>
        <p>App Perpustakaan menyediakan akses mudah ke koleksi buku dan sumber daya perpustakaan, dengan komitmen untuk layanan yang canggih dan memuaskan bagi semua pengguna.</p>
        <ul class="social-media">
          <li><a href=""><i class="fa-brands fa-facebook-f"></i></a></li>
          <li><a href=""><i class="fa-brands fa-x-twitter"></i></a></li>
          <li><a href=""><i class="fa-brands fa-instagram"></i></a></li>
          <li><a href=""><i class="fa-brands fa-youtube"></i></a></li>
        </ul>
      </div>
      <div class="footer-section panduan">
        <h4>Panduan Pengguna</h4>

        <ul>
          <li class="using-book"><a href="?page=tentang_kami&goal=1">Cara menggunakan App Perpustakaan</a></li>
          <li><a href="?page=tentang_kami&goal=3">Peminjaman buku</a></li>
          <li><a href="?page=tentang_kami&goal=4">Pengembalian buku</a></li>
          <li><a href="?page=tentang_kami&goal=faq">FAQ</a></li>
        </ul>
      </div>
      <div class="footer-section kontak">
        <h4>Kontak Kami</h4>

        <ul>
          <li>
            <i class="fa-solid fa-phone"></i>
            <div class="telepon">
              <h5>Telepon</h5>
              <p>08123456789</p>
            </div>
          </li>
          <li>
            <i class="fa-solid fa-envelope"></i>
            <div class="email">
              <h5>Email</h5>
              <p>appperpustakaan123@example.com</p>
            </div>
          </li>
          <li>
            <i class="fa-solid fa-location-dot"></i>
            <div class="lokasi">
              <h5>Lokasi</h5>
              <p>Jl. North Street No. 10, Country Name </p>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </footer>
  <p class="hak-cipta">&copy; 2024 App Perpustakaan. Semua hak cipta dilindungi.</p>

  <script src="assets/js/script.js"></script>
  <script>
    document.getElementById('hamburger-menu').addEventListener('click', function(e) {
  const navLinks = document.querySelector('.mid-links');
  navLinks.classList.toggle('active');
  });

  </script>
</body>

</html>