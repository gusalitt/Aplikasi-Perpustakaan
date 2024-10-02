<?php
  $redirect = isset($_SESSION['page_redirect']) ? $_SESSION['page_redirect'] : 'index.php';
  echo $redirect;

  if (!(isset($_GET['id_buku'])) || $_GET['id_buku'] == '') {
    header("Location: $redirect");
    unset($_SESSION['page_redirect']);
    exit;
  } 

  $cek_lastId = "SELECT id_buku FROM buku ORDER BY id_buku DESC LIMIT 1";
  $stmt = $conn->prepare($cek_lastId);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $last_row = $result->fetch_assoc();
    $last_id_buku = $last_row['id_buku']; 
  } else {
    $last_id_buku = "A000";
  }
  $stmt->close();

  if (strcmp($_GET['id_buku'], $last_id_buku) > 0) {
    header("Location: $redirect");
    unset($_SESSION['page_redirect']);
    exit;
  }

  // Mendapatkan semua data buku.
  $data_sql = "SELECT * FROM buku WHERE id_buku = ?";
  $stmt = $conn->prepare($data_sql);
  $stmt->bind_param('s', $_GET['id_buku']);
  $stmt->execute();
  $result = $stmt->get_result();
  $row = [];
  
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
  } else {
    header("Location: $redirect");
    unset($_SESSION['page_redirect']);
    exit;
  }
  $stmt->close();

  // Update kolom views di tabel buku.
  $update_sql = "UPDATE buku SET views = views + 1 WHERE id_buku = ?";
  $update_stmt = $conn->prepare($update_sql);
  $update_stmt->bind_param('s', $_GET['id_buku']);
  $update_stmt->execute();
  $update_stmt->close();

?>


<section class="book-details">
  <div class="details-header">
    <div class="img">
      <img src="https://picsum.photos/255/300" alt="cover-book">
    </div>
    <div class="details-content">
      <div class="tabs" role="tablist">
        <button role="tab" aria-selected="true" aria-controls="panel1" id="tab1">Informasi Buku</button>
        <button role="tab" aria-selected="false" aria-controls="panel2" id="tab2">Deskripsi</button>
      </div>
    
      <div role="tabpanel" id="panel1" aria-labelledby="tab1">
        <h2><?= $row['judul_buku']; ?></h2>
        <p>ID Buku : <span><?= $row['id_buku']; ?></span></p>
        <p>Pengarang : <span><?= $row['pengarang']; ?></span></p>
        <p>Penerbit : <span><?= $row['penerbit']; ?></span></p>
        <p>Tahun Terbit : <span><?= $row['tahun_terbit']; ?></span></p>
        <p>Jumlah Halaman : <span>305</span></p>

        <?php

          if (!(isset($_SESSION['id_pengguna'])) || $_SESSION['id_pengguna'] == '') {
        ?>
            <p class="login">Harap Login terlebih dahulu untuk meminjam buku ini.</p>
        <?php
          } else {
        ?>
            <form action="?page=kelola_data_buku" method="post">
              <input type="hidden" name="id_pengguna" value="<?= $_SESSION['id_pengguna']; ?>" style="display: none;" readonly>
              <input type="hidden" name="id_pinjam" value="<?= $row['id_buku']; ?>" style="display: none;" readonly>
              <button type="submit">Pinjam</button>
            </form>
        <?php
          }
        ?>
      </div>
      <div role="tabpanel" id="panel2" aria-labelledby="tab2" hidden>
        <h2><?= $row['judul_buku']; ?></h2>
        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Quisquam accusantium dolorem corporis, molestiae, totam quia cum magnam saepe atque velit corrupti quis, commodi consectetur iste vitae a ducimus recusandae id deleniti esse maiores maxime sit porro dicta. Laborum minus repellendus inventore soluta sint, voluptate at itaque magnam cumque quas nihil ex nisi dolorem quis, delectus ab unde earum quod dignissimos!</p>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quam autem reiciendis asperiores facilis nesciunt quod quibusdam tempora ratione ipsum! Aliquid est voluptatibus quidem voluptatum veniam eaque similique? Ipsa, asperiores minima officia accusantium labore neque quaerat, quod, recusandae odit magni vel culpa laborum voluptates nulla quidem provident. Incidunt inventore doloremque saepe.</p>
      </div>
    </div>
  </div>
  <div class="details-story">
    <div class="tabs" role="tablist">
      <button role="tab" aria-selected="true" aria-controls="panel4" id="tab4">Cerita</button>
      <button role="tab" aria-selected="false" aria-controls="panel5" id="tab5">Author Bio</button>
    </div>
  
    <div role="tabpanel" id="panel4" aria-labelledby="tab4">
      <div class="bab">

      <?php
        if (!(isset($_SESSION['nama_pengguna']))) {
          ?>
          <p class="message">Nikmati pengalaman membaca tanpa batas! <a href="login_user.php" class="login">Login</a> sekarang untuk membaca buku ini.</p>
        <?php  
        } else {
        ?>
        <h2><?= $row['judul_buku']; ?></h2>

        <ul class="bab-wrapper">
          <li class="bab-row">
            <div class="bab-content">
              <p>Bab I - Lorem ipsum dolor sit.</p>
              <i class="fa-solid fa-chevron-down"></i>
            </div>
            <ul class="fill">
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo dolorem aspernatur ex temporibus neque? Deserunt beatae libero incidunt, placeat labore dicta eaque perspiciatis, magnam minus accusamus voluptatum rerum possimus delectus maiores illum excepturi sit id, non fugit ea pariatur aspernatur eos minima. Doloremque laborum, repellat illo optio quod dolorum deleniti, quam, nam sit obcaecati quaerat consequatur quas animi ut praesentium?</li>
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse, maxime labore quia laboriosam cupiditate hic obcaecati debitis quis corrupti, reprehenderit facilis placeat perferendis quam pariatur iure ea quod modi iste atque dolore rem ipsum quibusdam a itaque! Suscipit maiores laborum, reprehenderit, vel commodi dignissimos ducimus labore itaque voluptatem adipisci quae cupiditate praesentium dicta ipsum velit nostrum explicabo odio ea aut! Et eius sint a, odio, sed magni aut maiores alias labore ea, atque qui libero illum enim provident temporibus itaque.</li>
            </ul>
          </li>
          <li class="bab-row">
            <div class="bab-content">
            <p>Bab II - Lorem ipsum dolor sit.</p>
              <i class="fa-solid fa-chevron-down"></i>
            </div>
            <ul class="fill">
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo dolorem aspernatur ex temporibus neque? Deserunt beatae libero incidunt, placeat labore dicta eaque perspiciatis, magnam minus accusamus voluptatum rerum possimus delectus maiores illum excepturi sit id, non fugit ea pariatur aspernatur eos minima. Doloremque laborum, repellat illo optio quod dolorum deleniti, quam, nam sit obcaecati quaerat consequatur quas animi ut praesentium?</li>
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse, maxime labore quia laboriosam cupiditate hic obcaecati debitis quis corrupti, reprehenderit facilis placeat perferendis quam pariatur iure ea quod modi iste atque dolore rem ipsum quibusdam a itaque! Suscipit maiores laborum, reprehenderit, vel commodi dignissimos ducimus labore itaque voluptatem adipisci quae cupiditate praesentium dicta ipsum velit nostrum explicabo odio ea aut! Et eius sint a, odio, sed magni aut maiores alias labore ea, atque qui libero illum enim provident temporibus itaque.</li>
            </ul>
          </li>
          <li class="bab-row">
            <div class="bab-content">
              <p>Bab III - Lorem ipsum dolor sit.</p>
              <i class="fa-solid fa-chevron-down"></i>
            </div>
            <ul class="fill">
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo dolorem aspernatur ex temporibus neque? Deserunt beatae libero incidunt, placeat labore dicta eaque perspiciatis, magnam minus accusamus voluptatum rerum possimus delectus maiores illum excepturi sit id, non fugit ea pariatur aspernatur eos minima. Doloremque laborum, repellat illo optio quod dolorum deleniti, quam, nam sit obcaecati quaerat consequatur quas animi ut praesentium?</li>
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse, maxime labore quia laboriosam cupiditate hic obcaecati debitis quis corrupti, reprehenderit facilis placeat perferendis quam pariatur iure ea quod modi iste atque dolore rem ipsum quibusdam a itaque! Suscipit maiores laborum, reprehenderit, vel commodi dignissimos ducimus labore itaque voluptatem adipisci quae cupiditate praesentium dicta ipsum velit nostrum explicabo odio ea aut! Et eius sint a, odio, sed magni aut maiores alias labore ea, atque qui libero illum enim provident temporibus itaque.</li>
            </ul>
          </li>
          <li class="bab-row">
            <div class="bab-content">
              <p>Bab IV - Lorem ipsum dolor sit.</p>
              <i class="fa-solid fa-chevron-down"></i>
            </div>
            <ul class="fill">
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo dolorem aspernatur ex temporibus neque? Deserunt beatae libero incidunt, placeat labore dicta eaque perspiciatis, magnam minus accusamus voluptatum rerum possimus delectus maiores illum excepturi sit id, non fugit ea pariatur aspernatur eos minima. Doloremque laborum, repellat illo optio quod dolorum deleniti, quam, nam sit obcaecati quaerat consequatur quas animi ut praesentium?</li>
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse, maxime labore quia laboriosam cupiditate hic obcaecati debitis quis corrupti, reprehenderit facilis placeat perferendis quam pariatur iure ea quod modi iste atque dolore rem ipsum quibusdam a itaque! Suscipit maiores laborum, reprehenderit, vel commodi dignissimos ducimus labore itaque voluptatem adipisci quae cupiditate praesentium dicta ipsum velit nostrum explicabo odio ea aut! Et eius sint a, odio, sed magni aut maiores alias labore ea, atque qui libero illum enim provident temporibus itaque.</li>
            </ul>
          </li>
          <li class="bab-row">
            <div class="bab-content">
              <p>Bab V - Lorem ipsum dolor sit.</p>
              <i class="fa-solid fa-chevron-down"></i>
            </div>
            <ul class="fill">
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo dolorem aspernatur ex temporibus neque? Deserunt beatae libero incidunt, placeat labore dicta eaque perspiciatis, magnam minus accusamus voluptatum rerum possimus delectus maiores illum excepturi sit id, non fugit ea pariatur aspernatur eos minima. Doloremque laborum, repellat illo optio quod dolorum deleniti, quam, nam sit obcaecati quaerat consequatur quas animi ut praesentium?</li>
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse, maxime labore quia laboriosam cupiditate hic obcaecati debitis quis corrupti, reprehenderit facilis placeat perferendis quam pariatur iure ea quod modi iste atque dolore rem ipsum quibusdam a itaque! Suscipit maiores laborum, reprehenderit, vel commodi dignissimos ducimus labore itaque voluptatem adipisci quae cupiditate praesentium dicta ipsum velit nostrum explicabo odio ea aut! Et eius sint a, odio, sed magni aut maiores alias labore ea, atque qui libero illum enim provident temporibus itaque.</li>
            </ul>
          </li>
          <li class="bab-row">
            <div class="bab-content">
              <p>Bab VI - Lorem ipsum dolor sit.</p>
              <i class="fa-solid fa-chevron-down"></i>
            </div>
            <ul class="fill">
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo dolorem aspernatur ex temporibus neque? Deserunt beatae libero incidunt, placeat labore dicta eaque perspiciatis, magnam minus accusamus voluptatum rerum possimus delectus maiores illum excepturi sit id, non fugit ea pariatur aspernatur eos minima. Doloremque laborum, repellat illo optio quod dolorum deleniti, quam, nam sit obcaecati quaerat consequatur quas animi ut praesentium?</li>
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse, maxime labore quia laboriosam cupiditate hic obcaecati debitis quis corrupti, reprehenderit facilis placeat perferendis quam pariatur iure ea quod modi iste atque dolore rem ipsum quibusdam a itaque! Suscipit maiores laborum, reprehenderit, vel commodi dignissimos ducimus labore itaque voluptatem adipisci quae cupiditate praesentium dicta ipsum velit nostrum explicabo odio ea aut! Et eius sint a, odio, sed magni aut maiores alias labore ea, atque qui libero illum enim provident temporibus itaque.</li>
            </ul>
          </li>
          <li class="bab-row">
            <div class="bab-content">
              <p>Bab VII - Lorem ipsum dolor sit.</p>
              <i class="fa-solid fa-chevron-down"></i>
            </div>
            <ul class="fill">
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo dolorem aspernatur ex temporibus neque? Deserunt beatae libero incidunt, placeat labore dicta eaque perspiciatis, magnam minus accusamus voluptatum rerum possimus delectus maiores illum excepturi sit id, non fugit ea pariatur aspernatur eos minima. Doloremque laborum, repellat illo optio quod dolorum deleniti, quam, nam sit obcaecati quaerat consequatur quas animi ut praesentium?</li>
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse, maxime labore quia laboriosam cupiditate hic obcaecati debitis quis corrupti, reprehenderit facilis placeat perferendis quam pariatur iure ea quod modi iste atque dolore rem ipsum quibusdam a itaque! Suscipit maiores laborum, reprehenderit, vel commodi dignissimos ducimus labore itaque voluptatem adipisci quae cupiditate praesentium dicta ipsum velit nostrum explicabo odio ea aut! Et eius sint a, odio, sed magni aut maiores alias labore ea, atque qui libero illum enim provident temporibus itaque.</li>
            </ul>
          </li>
          <li class="bab-row">
            <div class="bab-content">
              <p>Bab VIII - Lorem ipsum dolor sit.</p>
              <i class="fa-solid fa-chevron-down"></i>
            </div>
            <ul class="fill">
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo dolorem aspernatur ex temporibus neque? Deserunt beatae libero incidunt, placeat labore dicta eaque perspiciatis, magnam minus accusamus voluptatum rerum possimus delectus maiores illum excepturi sit id, non fugit ea pariatur aspernatur eos minima. Doloremque laborum, repellat illo optio quod dolorum deleniti, quam, nam sit obcaecati quaerat consequatur quas animi ut praesentium?</li>
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse, maxime labore quia laboriosam cupiditate hic obcaecati debitis quis corrupti, reprehenderit facilis placeat perferendis quam pariatur iure ea quod modi iste atque dolore rem ipsum quibusdam a itaque! Suscipit maiores laborum, reprehenderit, vel commodi dignissimos ducimus labore itaque voluptatem adipisci quae cupiditate praesentium dicta ipsum velit nostrum explicabo odio ea aut! Et eius sint a, odio, sed magni aut maiores alias labore ea, atque qui libero illum enim provident temporibus itaque.</li>
            </ul>
          </li>
          <li class="bab-row">
            <div class="bab-content">
              <p>Bab IX - Lorem ipsum dolor sit.</p>
              <i class="fa-solid fa-chevron-down"></i>
            </div>
            <ul class="fill">
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo dolorem aspernatur ex temporibus neque? Deserunt beatae libero incidunt, placeat labore dicta eaque perspiciatis, magnam minus accusamus voluptatum rerum possimus delectus maiores illum excepturi sit id, non fugit ea pariatur aspernatur eos minima. Doloremque laborum, repellat illo optio quod dolorum deleniti, quam, nam sit obcaecati quaerat consequatur quas animi ut praesentium?</li>
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse, maxime labore quia laboriosam cupiditate hic obcaecati debitis quis corrupti, reprehenderit facilis placeat perferendis quam pariatur iure ea quod modi iste atque dolore rem ipsum quibusdam a itaque! Suscipit maiores laborum, reprehenderit, vel commodi dignissimos ducimus labore itaque voluptatem adipisci quae cupiditate praesentium dicta ipsum velit nostrum explicabo odio ea aut! Et eius sint a, odio, sed magni aut maiores alias labore ea, atque qui libero illum enim provident temporibus itaque.</li>
            </ul>
          </li>
          <li class="bab-row">
            <div class="bab-content">
              <p>Bab X - Lorem ipsum dolor sit.</p>
              <i class="fa-solid fa-chevron-down"></i>
            </div>
            <ul class="fill">
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo dolorem aspernatur ex temporibus neque? Deserunt beatae libero incidunt, placeat labore dicta eaque perspiciatis, magnam minus accusamus voluptatum rerum possimus delectus maiores illum excepturi sit id, non fugit ea pariatur aspernatur eos minima. Doloremque laborum, repellat illo optio quod dolorum deleniti, quam, nam sit obcaecati quaerat consequatur quas animi ut praesentium?</li>
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse, maxime labore quia laboriosam cupiditate hic obcaecati debitis quis corrupti, reprehenderit facilis placeat perferendis quam pariatur iure ea quod modi iste atque dolore rem ipsum quibusdam a itaque! Suscipit maiores laborum, reprehenderit, vel commodi dignissimos ducimus labore itaque voluptatem adipisci quae cupiditate praesentium dicta ipsum velit nostrum explicabo odio ea aut! Et eius sint a, odio, sed magni aut maiores alias labore ea, atque qui libero illum enim provident temporibus itaque.</li>
            </ul>
          </li>
          <li class="bab-row">
            <div class="bab-content">
              <p>Bab XI - Lorem ipsum dolor sit.</p>
              <i class="fa-solid fa-chevron-down"></i>
            </div>
            <ul class="fill">
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo dolorem aspernatur ex temporibus neque? Deserunt beatae libero incidunt, placeat labore dicta eaque perspiciatis, magnam minus accusamus voluptatum rerum possimus delectus maiores illum excepturi sit id, non fugit ea pariatur aspernatur eos minima. Doloremque laborum, repellat illo optio quod dolorum deleniti, quam, nam sit obcaecati quaerat consequatur quas animi ut praesentium?</li>
              <li>Lorem ipsum dolor sit amet consectetur adipisicing elit. Esse, maxime labore quia laboriosam cupiditate hic obcaecati debitis quis corrupti, reprehenderit facilis placeat perferendis quam pariatur iure ea quod modi iste atque dolore rem ipsum quibusdam a itaque! Suscipit maiores laborum, reprehenderit, vel commodi dignissimos ducimus labore itaque voluptatem adipisci quae cupiditate praesentium dicta ipsum velit nostrum explicabo odio ea aut! Et eius sint a, odio, sed magni aut maiores alias labore ea, atque qui libero illum enim provident temporibus itaque.</li>
            </ul>
          </li>
        </ul>
        <?php
        }
        ?>
      </div>
    </div>
    <div role="tabpanel" id="panel5" aria-labelledby="tab5" hidden>
      <?php
      
      if (!(isset($_SESSION['nama_pengguna']))) {
        ?>
        <p class="message">Nikmati pengalaman membaca tanpa batas! <a href="login_user.php"  class="login">Login</a> sekarang untuk membaca buku ini.</p>

      <?php  
      } else  {
      ?>
        <h2><?= $row['pengarang']; ?></h2>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Id, sed. Mollitia esse aperiam fugiat officiis eligendi sequi reprehenderit dolor deserunt deleniti, laboriosam suscipit fugit. Esse nihil fugit perferendis vitae sint cupiditate nulla quis eum. Eveniet consectetur illum ab quas soluta amet laborum. Necessitatibus ratione at cupiditate minima, ea eligendi nemo explicabo illo beatae enim nulla omnis, rem, dolores quod deserunt.</p>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Inventore laudantium molestias, quia voluptatum in debitis ullam optio ipsum veniam, velit, asperiores ratione quos. Nulla cum eius deleniti libero ab blanditiis assumenda in commodi eveniet quo ea a nisi, pariatur alias praesentium delectus tempore harum quas. Dolore maiores rerum quis amet?</p>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni soluta, maiores laboriosam veniam magnam voluptatum nisi facere, quisquam aut adipisci sint perferendis reprehenderit ea ipsa, itaque dolor eum similique corporis provident! Unde nemo quo aperiam dolor eligendi, corporis voluptates quaerat reprehenderit labore placeat quibusdam, dolorum quos officia, distinctio delectus earum cumque? Reprehenderit quaerat vero molestias!</p>
      <?php
      }
      $conn->close();
      ?>  
    </div>
  </div>
</section>