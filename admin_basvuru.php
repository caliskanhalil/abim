<?php
include 'db.php'; // Veritabanı bağlantısı

// Silme işlemi
if (isset($_GET['sil'])) {
    $sil_id = intval($_GET['sil']);
    $conn->query("DELETE FROM basvurular WHERE id = $sil_id");
    header("Location: admin_basvurular.php");
    exit;
}

// Eğitimleri çek (filtre için)
$egitimler = $conn->query("SELECT id, baslik FROM egitimler");

// Seçilen eğitime göre başvuruları çek
$filtre = '';
if (isset($_GET['egitim_id']) && $_GET['egitim_id'] !== '') {
    $filtre_egitim_id = intval($_GET['egitim_id']);
    $filtre = "WHERE b.egitim_id = $filtre_egitim_id";
}

// Başvuruları çek
$sql = "SELECT b.id, b.ad, b.soyad, b.telefon, b.dogum_tarihi, b.basvuru_tarihi, e.baslik AS egitim_baslik
        FROM basvurular b
        JOIN egitimler e ON b.egitim_id = e.id
        $filtre
        ORDER BY b.basvuru_tarihi DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Başvurular Listesi</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 30px; background-color: #f9f9f9; }
    table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
    th { background-color: #4CAF50; color: white; }
    h2 { text-align: center; margin-bottom: 20px; }
    .container { max-width: 1200px; margin: auto; }
    .sil-btn {
      background-color: #e74c3c;
      color: white;
      padding: 6px 12px;
      text-decoration: none;
      border-radius: 6px;
      font-size: 14px;
      transition: background-color 0.3s ease;
    }
    .sil-btn:hover {
      background-color: #c0392b;
    }
    .filtre-form {
      margin-bottom: 20px;
      text-align: center;
    }
    .filtre-form select {
      padding: 8px;
      font-size: 16px;
    }
    .filtre-form button {
      padding: 8px 16px;
      font-size: 16px;
      background-color: #3498db;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin-left: 10px;
    }
    .filtre-form button:hover {
      background-color: #2980b9;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Başvurular Listesi</h2>

  <!-- Filtre Formu -->
  <div style="text-align: center; margin-bottom: 20px;">
  <a href="export_excel.php" style="background-color: #27ae60; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-size: 16px;">
    Excel'e Aktar
  </a>
</div>

  <form method="GET" class="filtre-form">
    <label for="egitim_id">Eğitim Seç:</label>
    <select name="egitim_id" id="egitim_id">
      <option value="">Tüm Eğitimler</option>
      <?php while($egitim = $egitimler->fetch_assoc()): ?>
        <option value="<?php echo $egitim['id']; ?>" <?php if (isset($filtre_egitim_id) && $filtre_egitim_id == $egitim['id']) echo 'selected'; ?>>
          <?php echo htmlspecialchars($egitim['baslik']); ?>
        </option>
      <?php endwhile; ?>
    </select>
    <button type="submit">Filtrele</button>
  </form>

  <!-- Başvurular Tablosu -->
  <?php if ($result->num_rows > 0): ?>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Ad</th>
          <th>Soyad</th>
          <th>Telefon</th>
          <th>Doğum Tarihi</th>
          <th>Başvurduğu Eğitim</th>
          <th>Başvuru Tarihi</th>
          <th>İşlem</th>
        </tr>
      </thead>
      <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo htmlspecialchars($row['ad']); ?></td>
          <td><?php echo htmlspecialchars($row['soyad']); ?></td>
          <td><?php echo htmlspecialchars($row['telefon']); ?></td>
          <td><?php echo htmlspecialchars($row['dogum_tarihi']); ?></td>
          <td><?php echo htmlspecialchars($row['egitim_baslik']); ?></td>
          <td><?php echo htmlspecialchars($row['basvuru_tarihi']); ?></td>
          <td><a href="?sil=<?php echo $row['id']; ?>" class="sil-btn" onclick="return confirm('Bu başvuruyu silmek istediğinize emin misiniz?')">Sil</a></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>Başvuru bulunamadı.</p>
  <?php endif; ?>

</div>

</body>
</html>
