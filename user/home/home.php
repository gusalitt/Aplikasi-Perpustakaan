<section class="hero">
  <div class="main-hero">
    <div class="hero-content">
      <h1>Jelajahi Dunia Pengetahuan dengan Setiap Langkah</h1>
      <p>Koleksi buku kami menanti untuk menemani Anda dalam perjalanan intelektual yang penuh makna. Setiap halaman menawarkan wawasan dan inspirasi yang tak terbatas, siap memperkaya pengetahuan Anda.</p>
      <a href="?page=koleksi_buku" class="btn-hero">Mulai Penjelajahan Anda</a>
    </div>
    <div class="hero-image">
      <img src="assets/img/hero.png" alt="hero-image">
    </div>
  </div>
</section>

<section class="recent-book">
  <h2>Buku Terbaru</h2>

  <div class="card-container">
    <?php
      $sql = "SELECT * FROM buku ORDER BY tahun_terbit DESC LIMIT 5";
      $stmt = $conn->prepare($sql);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
    ?>

          <div class="card">
            <a href="?page=detail_buku&id_buku=<?= $row['id_buku']; ?>" class="cover-book"><img src="https://picsum.photos/255/400" alt="cover-book-random"></a>
            <div class="card-content">
              <h3 class="title-book"><?= $row['judul_buku']?></h3>
              <p class="pengarang"><span><i class="fa-regular fa-pen-to-square"></i> <?= $row['pengarang'] ?></span></p>

              <a href="?page=detail_buku&id_buku=<?= $row['id_buku']; ?>" class="btn-detail">Lihat Detail</a>
            </div>
          </div>

    <?php
        }
      }
      $stmt->close();
    ?>
  </div>
</section>

<section class="popular-book">
  <h2>Buku yang sering Dibaca</h2>

  <div class="card-container">
    <?php
      $check_sql = "SELECT views FROM buku";
      $check_stmt = $conn->prepare($check_sql);
      $check_stmt->execute();
      $result_check = $check_stmt->get_result();
      $order_by = "id_buku DESC";

      if ($result_check->num_rows > 0) {
        while ($views = $result_check->fetch_assoc()) {
          if ($views['views'] > 0) {
            $order_by = "views DESC";
            break;
          }
        }
      }
      $check_stmt->close();

      $loop_sql = "SELECT * FROM buku ORDER BY $order_by LIMIT 8";
      $loop_stmt = $conn->prepare($loop_sql);
      $loop_stmt->execute();
      $result_loop = $loop_stmt->get_result();

      if ($result_loop->num_rows > 0) {
        while ($row = $result_loop->fetch_assoc()) {
      ?>

          <div class="card">
            <a href="?page=detail_buku&id_buku=<?= $row['id_buku']; ?>" class="cover-book"><img src="https://picsum.photos/255/400" alt="cover-book-random"></a>
            <div class="card-content">
              <h3 class="title-book"><?= $row['judul_buku']?></h3>
              <p class="pengarang"><span><i class="fa-regular fa-pen-to-square"></i> <?= $row['pengarang'] ?></span></p>

              <a href="?page=detail_buku&id_buku=<?= $row['id_buku']; ?>" class="btn-detail">Lihat Detail</a>
            </div>
          </div>

      <?php
        }
      }
      $loop_stmt->close();
      $conn->close();
    ?>
</div>

  <a href="?page=koleksi_buku" class="see-all">Lihat semua buku <i class="fa-solid fa-arrow-right"></i></a>
</section>
