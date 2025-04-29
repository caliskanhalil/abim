<?php
include 'db.php'; // Veritabanı bağlantısı

// id parametresi var mı kontrol et
if (isset($_GET['id'])) {
    $egitim_id = intval($_GET['id']); // güvenlik için integer'a çeviriyoruz

    // Veritabanından ilgili eğitimi çek
    $sql = "SELECT * FROM egitimler WHERE id = $egitim_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $egitim = $result->fetch_assoc();
    } else {
        echo "Eğitim bulunamadı.";
        exit;
    }
} else {
    echo "Geçersiz eğitim ID.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($egitim['baslik']); ?> - Eğitim Detayı</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .egitim-detay {
      max-width: 800px;
      margin: 40px auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }
    .egitim-detay img {
      width: 100%;
      border-radius: 10px;
      margin-bottom: 20px;
    }
    .egitim-detay h2 {
      font-size: 2em;
      margin-bottom: 10px;
      color: #333;
    }
    .egitim-detay p {
      font-size: 1.1em;
      line-height: 1.6;
      margin-bottom: 20px;
      color: #555;
    }
    .egitim-detay .bilgi {
      background: #f9f9f9;
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 20px;
    }
    .basvur-btn {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 12px 24px;
      font-size: 1em;
      cursor: pointer;
      border-radius: 8px;
      transition: background-color 0.3s ease;
      display: inline-block;
      text-decoration: none;
    }
    .basvur-btn:hover {
      background-color: #45a049;
    }
    header, footer {
      background-color: #333;
      color: white;
      text-align: center;
      padding: 15px;
    }
    nav ul {
      list-style: none;
      padding: 0;
    }
    nav ul li {
      display: inline;
      margin-right: 20px;
    }
    nav ul li a {
      color: white;
      text-decoration: none;
    }
  </style>
</head>
<body>

<header>
  <h1>Eğitim Detayı</h1>
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
  <section class="egitim-detay">
    <!-- Eğitim Görseli -->
    <?php if (!empty($egitim['resim_url'])): ?>
      <img src="<?php echo htmlspecialchars($egitim['resim_url']); ?>" alt="<?php echo htmlspecialchars($egitim['baslik']); ?>">
    <?php else: ?>
      <img src="https://picsum.photos/800/400" alt="Eğitim Resmi">
    <?php endif; ?>

    <!-- Eğitim Başlığı -->
    <h2><?php echo htmlspecialchars($egitim['baslik']); ?></h2>

    <!-- Eğitim Müfredatı -->
    <div class="bilgi">
      <h3>Müfredat</h3>
      <p><?php echo nl2br(htmlspecialchars($egitim['mufredat'])); ?></p>
    </div>

    <!-- Eğitim Süresi -->
    <div class="bilgi">
      <h3>Eğitim Süresi</h3>
      <p><strong>Başlangıç:</strong> <?php echo htmlspecialchars($egitim['baslangic_tarihi']); ?> <br>
         <strong>Bitiş:</strong> <?php echo htmlspecialchars($egitim['bitis_tarihi']); ?></p>
    </div>

    <!-- Eğitim Gün ve Saat Bilgisi -->
    <div class="bilgi">
      <h3>Gün ve Saat</h3>
      <p><?php echo htmlspecialchars($egitim['gun_saat']); ?></p>
    </div>

    <!-- Başvur Butonu -->
    <a href="basvuru.php?egitim_id=<?php echo $egitim_id; ?>" class="basvur-btn">Eğitime Başvur</a>
  </section>
</main>

<footer>
  <p>Tüm hakları saklıdır &copy; 2025</p>
</footer>

</body>
</html>
