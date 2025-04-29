<?php
include 'db.php'; // Veritabanı bağlantısını dahil et

// Eğitimleri veritabanından çek
$sql = "SELECT * FROM egitimler"; // Eğitimler tablosundan tüm verileri çek
$result = $conn->query($sql); // Sorguyu çalıştır
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eğitimlerimiz</title>
  <link rel="stylesheet" href="style.css">

</head>
<body>
  <header>
    <h1>Hakkımızda</h1>
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
    <h2>Eğitimlerimiz</h2>
    <div class="cards">
      <?php
      if ($result->num_rows > 0) {
        // Veritabanından eğitimleri çekip her birini döngüyle göster
        while ($row = $result->fetch_assoc()) {
          echo "<div class='card'>";
          // Resim URL'si varsa resmi göster
          if (!empty($row['resim_url'])) {
            echo "<img src='" . $row['resim_url'] . "' alt='Eğitim Resmi'>";
          } else {
            echo "<img src='https://picsum.photos/200' alt='Eğitim Resmi'>"; // Varsayılan resim
          }
          echo "<h3>" . $row['baslik'] . "</h3>";
          echo "<p>" . $row['aciklama'] . "</p>";
          echo "<a href='egitim_detay.php?id=" . $row['id'] . "' class='detail-btn'>Detay</a>";
          echo "<button class='join-btn'>Eğitime Katıl</button>";
          echo "</div>";
        }
      } else {
        echo "<p>Henüz eğitim bulunmamaktadır.</p>";
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
