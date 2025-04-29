<?php
$servername = "localhost";
$username = "root";  // MySQL kullanıcı adınız
$password = "";      // MySQL şifreniz
$dbname = "web_sitesi";  // Veritabanı adı

// Veritabanına bağlan
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Bağlantı başarısız: " . $conn->connect_error);
}
?>
