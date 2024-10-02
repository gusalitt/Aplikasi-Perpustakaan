<?php
  $order_by = "id_buku DESC";


  if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['sort'])) {
      $_SESSION['sort'] = $_POST['sort'];

      $redirect = isset($_SESSION['page_redirect']) ? $_SESSION['page_redirect'] : 'index.php';
      header("Location: $redirect");
      unset($_SESSION['page_redirect']);
      exit;
    }
  }

  if (isset($_SESSION['sort'])) {
    $sort = $_SESSION['sort']; 

    switch ($sort) {
      case 'terbaru':
        $order_by = "tahun_terbit DESC";
        break;
      case 'terlama':
        $order_by = "tahun_terbit ASC";
        break;
      case 'terpopuler':
        $order_by = "views DESC";
        break;
      case 'semua':
        $order_by = "id_buku DESC";
        break;
      default:
        $order_by = "id_buku DESC";
        break;
    }
  }

  $sql = "SELECT * FROM buku ORDER BY $order_by";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->get_result();


  function isSelected($key_page1) {
    if (isset($_SESSION['sort'])) {
      return $_SESSION['sort'] == $key_page1 ? 'selected' : ''; 
    }
    return '';
  }

  $num_of_books = $conn->prepare("SELECT COUNT(*) AS jumlah_buku FROM buku");
  $num_of_books->execute();
  $num_result =  $num_of_books->get_result();
  $amount = $num_result->fetch_assoc();
?>

<section class="book-collection">
  <h1>Buku (<span><?= $amount['jumlah_buku']; ?></span>)</h1>
  <p>Jelajahi semua buku berkualitas disini.</p>

  <div class="wrapper">
    <form action="" method="post">
      <label for="sort">Urutkan</label>
      <span>:</span>
      <select name="sort" id="sort" onchange="this.form.submit();">
        <option value="semua" <?= isSelected('semua'); ?>>Semua</option>
        <option value="terbaru" <?= isSelected('terbaru'); ?>>Buku Terbaru</option>
        <option value="terlama" <?= isSelected('terlama'); ?>>Buku Terlama</option>
        <option value="terpopuler" <?= isSelected('terpopuler'); ?>>Buku Terpopuler</option>
      </select>
    </form>
  
    <div class="search-box">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="search" name="search" id="search" placeholder="Cari buku..." >
    </div>
  </div>

  <div class="card-container">
    <?php

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
      ?>
        <div class="card">
          <a href="?page=detail_buku&id_buku=<?= $row['id_buku']; ?>" class="cover-book"><img src="https://picsum.photos/255/400" alt="cover-book-random"></a>
          <div class="card-content">
            <h3 class="title-book"><?= $row['judul_buku']; ?></h3>
            <p class="pengarang"><span><i class="fa-regular fa-pen-to-square"></i> <?= $row['pengarang']; ?></span></p>

            <a href="?page=detail_buku&id_buku=<?= $row['id_buku']; ?>" class="btn-detail">Lihat Detail</a>
          </div>
        </div>
      <?php
        }
      }
      $stmt->close();
      $conn->close();
    ?>
  </div>
</section>