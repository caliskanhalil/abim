<?php 
// Veritabanına bağlan
include 'db.php';

// Blog yazılarını veritabanından çek
$sql = "SELECT * FROM blog_yazilari";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Blog Yazılarımız</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Blog Yazılarımız</h1>
    <nav>
      <ul>
        <li><a href="index.html">Anasayfa</a></li>
        <li><a href="hakkimizda.html">Hakkımızda</a></li>
        <li><a href="iletisim.html">İletişim</a></li>
        <li><a href="egitimler.php">Eğitimler</a></li>
        <li><a href="blog.php">Blog</a></li>
        <li><a href="youtube.html">YouTube</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <h2>Blog Yazılarımız</h2>
    <div class="blog-cards">
      <?php
      // Eğer blog yazıları varsa, her birini döngü ile yazdır
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              // Açıklamanın sadece ilk 50 karakterini al
              $aciklama_preview = substr($row['aciklama'], 0, 50) . '...';

              echo "<div class='blog-card'>";
              echo "<img src='uploads/" . $row['resim'] . "' alt='Blog Yazısı Resmi'>";

              echo "<h3>" . $row['baslik'] . "</h3>";
              echo "<p>" . $aciklama_preview . "</p>";
              echo "<a href='detay.php?id=" . $row['id'] . "' class='detail-btn'>Oku</a>";
              echo "</div>";
          }
      } else {
          echo "<p>Blog yazısı bulunamadı.</p>";
      }
      ?>
    </div>
  </main>

  <footer>
    <p>Tüm hakları saklıdır &copy; 2025</p>
  </footer>

  <script src="script.js"></script>
</body>
</html>
