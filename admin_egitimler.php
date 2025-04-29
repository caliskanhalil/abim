<?php
// Veritabanına bağlan
include 'db.php';

// Yeni eğitim ekleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $baslik = $_POST['baslik'];
    $aciklama = $_POST['aciklama'];
    $mufredat = $_POST['mufredat'];
    $baslangic_tarihi = $_POST['baslangic_tarihi'];
    $bitis_tarihi = $_POST['bitis_tarihi'];
    $gun_saat = $_POST['gun_saat'];

    // Resim yükleme işlemi
    if (isset($_FILES['resim']) && $_FILES['resim']['error'] == 0) {
        $hedef_klasor = "uploads/"; // Yüklenecek klasör
        $dosya_adi = basename($_FILES["resim"]["name"]);
        $hedef_yol = $hedef_klasor . $dosya_adi;

        if (move_uploaded_file($_FILES["resim"]["tmp_name"], $hedef_yol)) {
            $resim_url = $hedef_yol;
        } else {
            echo "Resim yüklenirken hata oluştu.";
            exit;
        }
    } else {
        $resim_url = ""; // Resim yoksa boş bırak
    }

    // Yeni SQL sorgusu
    $sql = "INSERT INTO egitimler (baslik, aciklama, mufredat, baslangic_tarihi, bitis_tarihi, gun_saat, resim_url)
            VALUES ('$baslik', '$aciklama', '$mufredat', '$baslangic_tarihi', '$bitis_tarihi', '$gun_saat', '$resim_url')";

    if ($conn->query($sql) === TRUE) {
        echo "Yeni eğitim başarıyla eklendi!";
    } else {
        echo "Hata: " . $conn->error;
    }
}

// Eğitimleri çek
$sql = "SELECT * FROM egitimler";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Paneli - Eğitim Ekle</title>
  <style>
    /* senin eski stiller duruyor */
    body { font-family: Arial, sans-serif; margin: 30px; background-color: #f7f7f7; }
    h2 { color: #333; }
    form { background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 40px; }
    input[type="text"], textarea, input[type="file"], input[type="date"] {
        width: 100%; padding: 10px; margin-top: 6px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 8px;
    }
    button { background-color: #4CAF50; color: white; padding: 12px 20px; border: none; border-radius: 8px; cursor: pointer; }
    button:hover { background-color: #45a049; }
    table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    th, td { text-align: center; padding: 12px; border-bottom: 1px solid #ddd; }
    th { background-color: #f2f2f2; color: #333; }
    img { max-width: 100px; border-radius: 8px; }
    a { text-decoration: none; color: #2196F3; font-weight: bold; }
    a:hover { text-decoration: underline; }
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
<h2>Eğitim Ekle</h2>

<form action="admin_egitimler.php" method="POST" enctype="multipart/form-data">
    <label for="baslik">Eğitim Başlığı:</label>
    <input type="text" name="baslik" id="baslik" required>

    <label for="aciklama">Açıklama:</label>
    <textarea name="aciklama" id="aciklama" required></textarea>

    <label for="mufredat">Müfredat:</label>
    <textarea name="mufredat" id="mufredat" required></textarea>

    <label for="baslangic_tarihi">Başlangıç Tarihi:</label>
    <input type="date" name="baslangic_tarihi" id="baslangic_tarihi" required>

    <label for="bitis_tarihi">Bitiş Tarihi:</label>
    <input type="date" name="bitis_tarihi" id="bitis_tarihi" required>

    <label for="gun_saat">Ders Günleri ve Saatleri:</label>
    <input type="text" name="gun_saat" id="gun_saat" placeholder="Örn: Pazartesi-Çarşamba 18:00-20:00" required>

    <label for="resim">Resim Yükle:</label>
    <input type="file" name="resim" id="resim" accept="image/*">

    <button type="submit">Eğitim Ekle</button>
</form>

<h2>Mevcut Eğitimler</h2>

<table>
  <thead>
    <tr>
      <th>Başlık</th>
      <th>Açıklama</th>
      <th>Resim</th>
      <th>İşlemler</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['baslik']) . "</td>";
            echo "<td>" . htmlspecialchars($row['aciklama']) . "</td>";
            echo "<td><img src='" . htmlspecialchars($row['resim_url']) . "' alt='Eğitim Resmi'></td>";
            echo "<td>
                    <a href='edit_egitim.php?id=" . $row['id'] . "'>Düzenle</a> |
                    <a href='delete_egitim.php?id=" . $row['id'] . "' onclick=\"return confirm('Eğitimi silmek istediğine emin misin?');\">Sil</a>
                  </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>Henüz eğitim eklenmedi.</td></tr>";
    }
    ?>
  </tbody>
</table>

</body>
</html>
