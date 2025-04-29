<?php
include 'db.php'; // Veritabanı bağlantısı

// Eğitim ID kontrolü
if (!isset($_GET['egitim_id'])) {
    echo "Geçersiz istek.";
    exit;
}

$egitim_id = intval($_GET['egitim_id']);

// Eğitim bilgilerini al
$sql = "SELECT baslik FROM egitimler WHERE id = $egitim_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Eğitim bulunamadı.";
    exit;
}

$egitim = $result->fetch_assoc();

// Form gönderildiğinde başvuruyu kaydet
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ad = $_POST['ad'];
    $soyad = $_POST['soyad'];
    $telefon = $_POST['telefon'];
    $dogum_tarihi = $_POST['dogum_tarihi'];

    // Başvuru verisini kaydet
    $sql = "INSERT INTO basvurular (egitim_id, ad, soyad, telefon, dogum_tarihi) 
            VALUES ('$egitim_id', '$ad', '$soyad', '$telefon', '$dogum_tarihi')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Başvurunuz başarıyla alındı!'); window.location.href = 'egitimler.php';</script>";
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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo htmlspecialchars($egitim['baslik']); ?> - Başvuru Yap</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 30px; background-color: #f2f2f2; }
    form { background: #fff; padding: 25px; border-radius: 10px; max-width: 500px; margin: auto; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    input[type="text"], input[type="date"], button {
        width: 100%; padding: 10px; margin-top: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 8px;
    }
    button {
      background-color: #4CAF50; color: white; border: none; cursor: pointer;
    }
    button:hover {
      background-color: #45a049;
    }
    h2 { text-align: center; margin-bottom: 20px; }
  </style>
</head>
<body>

<h2><?php echo htmlspecialchars($egitim['baslik']); ?> Eğitimi Başvuru Formu</h2>

<form method="POST" action="">
    <label for="ad">Ad:</label>
    <input type="text" name="ad" id="ad" required>

    <label for="soyad">Soyad:</label>
    <input type="text" name="soyad" id="soyad" required>

    <label for="telefon">İletişim Numarası:</label>
    <input type="text" name="telefon" id="telefon" required>

    <label for="dogum_tarihi">Doğum Tarihi:</label>
    <input type="date" name="dogum_tarihi" id="dogum_tarihi" required>

    <button type="submit">Başvuruyu Gönder</button>
</form>

</body>
</html>
