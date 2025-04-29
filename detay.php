<?php 
// Veritabanına bağlan
include 'db.php';

// id parametresini al
if (isset($_GET['id'])) {
    $blog_id = intval($_GET['id']); // güvenlik için integer'a çeviriyoruz

    // Veritabanından ilgili blog yazısını çek
    $sql = "SELECT * FROM blog_yazilari WHERE id = $blog_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $blog = $result->fetch_assoc();
    } else {
        echo "Blog yazısı bulunamadı.";
        exit;
    }
} else {
    echo "Geçersiz blog ID.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($blog['baslik']); ?> - Blog Detayı</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Blog Yazısı Detayı</h1>
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
    <section class="blog-detail">
      <h2><?php echo htmlspecialchars($blog['baslik']); ?></h2>
      <img src="uploads/<?php echo htmlspecialchars($blog['resim']); ?>" alt="Blog Yazısı Resmi">
      <p><?php echo nl2br(htmlspecialchars($blog['aciklama'])); ?></p>
    </section>
  </main>

  <footer>
    <p>Tüm hakları saklıdır &copy; 2025</p>
  </footer>

  <script src="script.js"></script>
</body>
</html>
