<?php
// Veritabanına bağlan
include 'db.php';

// Eğitim ID'sini al
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Eğitim kaydını sil
    $sql = "DELETE FROM egitimler WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Silme başarılı → admin_egitimler.php sayfasına yönlendir
        header("Location: admin_egitimler.php");
        exit;
    } else {
        echo "Hata: " . $conn->error;
    }
} else {
    echo "Geçerli bir ID bulunamadı.";
}
?>
