<?php
// Veritabanına bağlan
include 'db.php';

// ID kontrolü
if (!isset($_GET['id'])) {
    echo "Geçersiz istek.";
    exit;
}

$id = intval($_GET['id']);

// Eğitim bilgilerini çek
$sql = "SELECT * FROM egitimler WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Eğitim bulunamadı.";
    exit;
}

$egitim = $result->fetch_assoc();

// Güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $baslik = $_POST['baslik'];
    $aciklama = $_POST['aciklama'];
    $mufredat = $_POST['mufredat'];
    $baslangic_tarihi = $_POST['baslangic_tarihi'];
    $bitis_tarihi = $_POST['bitis_tarihi'];
    $gun_saat = $_POST['gun_saat'];

    // Resim yükleme
    if (isset($_FILES['resim']) && $_FILES['resim']['error'] == 0) {
        $hedef_klasor = "uploads/";
        $dosya_adi = basename($_FILES["resim"]["name"]);
        $hedef_yol = $hedef_klasor . $dosya_adi;

        if (move_uploaded_file($_FILES["resim"]["tmp_name"], $hedef_yol)) {
            $resim_url = $hedef_yol;
        } else {
            echo "Resim yüklenirken hata oluştu.";
            exit;
        }
    } else {
        $resim_url = $egitim['resim_url']; // Mevcut resim kalacak
    }

    // Güncelleme sorgusu
    $sql = "UPDATE egitimler 
            SET baslik='$baslik', aciklama='$aciklama', mufredat='$mufredat', 
                baslangic_tarihi='$baslangic_tarihi', bitis_tarihi='$bitis_tarihi', 
                gun_saat='$gun_saat', resim_url='$resim_url'
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Eğitim başarıyla güncellendi!";
        header("Location: admin_egitimler.php"); // Güncelleyince listeye dön
        exit;
    } else {
        echo "Hata: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eğitim Düzenle</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 30px; background-color: #f7f7f7; }
    form { background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    input[type="text"], textarea, input[type="file"], input[type="date"] {
        width: 100%; padding: 10px; margin-top: 6px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 8px;
    }
    button { background-color: #2196F3; color: white; padding: 12px 20px; border: none; border-radius: 8px; cursor: pointer; }
    button:hover { background-color: #1976D2; }
    img { max-width: 150px; margin-top: 10px; }
  </style>
</head>
<body>

<h2>Eğitim Düzenle</h2>

<form action="edit_egitim.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
    <label for="baslik">Eğitim Başlığı:</label>
    <input type="text" name="baslik" id="baslik" value="<?php echo htmlspecialchars($egitim['baslik']); ?>" required>

    <label for="aciklama">Açıklama:</label>
    <textarea name="aciklama" id="aciklama" required><?php echo htmlspecialchars($egitim['aciklama']); ?></textarea>

    <label for="mufredat">Müfredat:</label>
    <textarea name="mufredat" id="mufredat" required><?php echo htmlspecialchars($egitim['mufredat']); ?></textarea>

    <label for="baslangic_tarihi">Başlangıç Tarihi:</label>
    <input type="date" name="baslangic_tarihi" id="baslangic_tarihi" value="<?php echo htmlspecialchars($egitim['baslangic_tarihi']); ?>" required>

    <label for="bitis_tarihi">Bitiş Tarihi:</label>
    <input type="date" name="bitis_tarihi" id="bitis_tarihi" value="<?php echo htmlspecialchars($egitim['bitis_tarihi']); ?>" required>

    <label for="gun_saat">Ders Günleri ve Saatleri:</label>
    <input type="text" name="gun_saat" id="gun_saat" value="<?php echo htmlspecialchars($egitim['gun_saat']); ?>" required>

    <label for="resim">Yeni Resim Yükle (İsteğe bağlı):</label>
    <input type="file" name="resim" id="resim" accept="image/*">
    <br>
    <img src="<?php echo htmlspecialchars($egitim['resim_url']); ?>" alt="Mevcut Eğitim Resmi">

    <button type="submit">Güncelle</button>
</form>

</body>
</html>
