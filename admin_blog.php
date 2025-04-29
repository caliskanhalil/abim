<?php
include 'db.php'; // Veritabanı bağlantısını dahil et

// Blog yazısını silmek
if (isset($_GET['sil'])) {
    $id = $_GET['sil'];
    $sql = "DELETE FROM blog_yazilari WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Blog yazısı başarıyla silindi.";
        header("Location: admin_blog.php"); // Silme işlemi sonrası sayfayı yenile
        exit;
    } else {
        echo "Veritabanı hatası: " . $conn->error;
    }
}

// Formdan gelen verileri kontrol et
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $baslik = $conn->real_escape_string($_POST['baslik']);
    $aciklama = $conn->real_escape_string($_POST['aciklama']);
    
    // Resim yükleme işlemi
    $hedefKlasor = "uploads/"; // Yükleme yapılacak klasör
    if (!is_dir($hedefKlasor)) {
        mkdir($hedefKlasor, 0777, true); // Klasör yoksa oluştur
    }

    $resimAdi = basename($_FILES['resim']['name']);
    $geciciIsim = $_FILES['resim']['tmp_name'];
    $yuklenecekYol = $hedefKlasor . $resimAdi;

    // Resim yükleme işlemi
    if (move_uploaded_file($geciciIsim, $yuklenecekYol)) {
        // Yükleme başarılı, veritabanına ekleme işlemi
        $sql = "INSERT INTO blog_yazilari (baslik, aciklama, resim) VALUES ('$baslik', '$aciklama', '$resimAdi')";

        if ($conn->query($sql) === TRUE) {
            echo "Blog yazısı başarıyla eklendi.";
            header("Location: admin_blog.php"); // Başarı durumunda sayfayı yenile
            exit;
        } else {
            echo "Veritabanı hatası: " . $conn->error;
        }
    } else {
        echo "Resim yüklenemedi. Lütfen tekrar deneyin.";
    }
}

// Veritabanından tüm blog yazılarını çek
$sql = "SELECT * FROM blog_yazilari ORDER BY id DESC"; // En son eklenen yazılar üstte olsun
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Yazısı Ekle</title>
    <style>
        /* CSS Stil */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-size: 16px;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        textarea,
        input[type="file"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        input[type="text"]:focus,
        textarea:focus,
        input[type="file"]:focus {
            outline: none;
            border-color: #66afe9;
        }

        input[type="submit"] {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .form-footer {
            text-align: center;
            margin-top: 20px;
        }

        .form-footer a {
            color: #4CAF50;
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        /* Blog Yazıları Listesi */
        .blog-list {
            margin-top: 40px;
        }

        .blog-item {
            background-color: #f9f9f9;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .blog-item h3 {
            margin-top: 0;
            color: #333;
        }

        .blog-item p {
            color: #666;
            line-height: 1.5;
        }

        .blog-item img {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            margin-top: 15px;
            border-radius: 5px;
        }

        .action-buttons {
            margin-top: 10px;
        }

        .action-buttons a {
            background-color: #4CAF50;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
            margin-right: 10px;
        }

        .action-buttons a:hover {
            background-color: #45a049;
        }

        .action-buttons .delete-btn {
            background-color: #f44336;
        }

        .action-buttons .delete-btn:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
    <!-- Admin Yönetimine Dön Butonu -->
  <div style="position: absolute; top: 20px; left: 20px;">
    <a href="admin_yonetim.html">
      <button style="background-color: #4CAF50; color: white; padding: 12px 20px; border: none; border-radius: 8px; cursor: pointer;">
        Admin Yönetimine Dön
      </button>
    </a>
  </div>

<div class="container">
    <h2>Blog Yazısı Ekle</h2>

    <form action="admin_blog.php" method="POST" enctype="multipart/form-data">
        <label for="baslik">Başlık:</label>
        <input type="text" id="baslik" name="baslik" required>

        <label for="aciklama">Açıklama:</label>
        <textarea id="aciklama" name="aciklama" rows="5" cols="40" required></textarea>

        <label for="resim">Resim Yükle:</label>
        <input type="file" id="resim" name="resim" accept="image/*" required>

        <input type="submit" value="Blog Yazısını Ekle">
    </form>

    <div class="form-footer">
        <a href="blog.php">Blog sayfasına dön</a>
    </div>

    <!-- Eklenen Blog Yazılarını Listele -->
    <div class="blog-list">
        <?php
        if ($result->num_rows > 0) {
            // Her bir yazıyı listele
            while ($row = $result->fetch_assoc()) {
                echo "<div class='blog-item'>";
                echo "<h3>" . htmlspecialchars($row['baslik']) . "</h3>";
                echo "<p>" . htmlspecialchars($row['aciklama']) . "</p>";
                if ($row['resim']) {
                    echo "<img src='uploads/" . htmlspecialchars($row['resim']) . "' alt='Blog Resmi'>";
                }
                echo "<div class='action-buttons'>";
                echo "<a href='edit_blog.php?id=" . $row['id'] . "'>Düzenle</a>";
                echo "<a href='admin_blog.php?sil=" . $row['id'] . "' class='delete-btn'>Sil</a>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>Henüz eklenmiş bir blog yazısı bulunmamaktadır.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>
