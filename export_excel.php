<?php
require 'vendor/autoload.php'; // PhpSpreadsheet'i çağır


include 'db.php'; // Veritabanı bağlantısı

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Yeni bir çalışma kitabı oluştur
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Başlıklar
$sheet->setCellValue('A1', 'ID');
$sheet->setCellValue('B1', 'Ad');
$sheet->setCellValue('C1', 'Soyad');
$sheet->setCellValue('D1', 'Telefon');
$sheet->setCellValue('E1', 'Doğum Tarihi');
$sheet->setCellValue('F1', 'Eğitim');
$sheet->setCellValue('G1', 'Başvuru Tarihi');

// Verileri veritabanından çekelim
$sql = "SELECT b.id, b.ad, b.soyad, b.telefon, b.dogum_tarihi, b.basvuru_tarihi, e.baslik AS egitim_baslik
        FROM basvurular b
        JOIN egitimler e ON b.egitim_id = e.id
        ORDER BY b.basvuru_tarihi DESC";

$result = $conn->query($sql);

$rowNumber = 2; // 2. satırdan başlıyoruz çünkü 1. satır başlıklar
while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue('A' . $rowNumber, $row['id']);
    $sheet->setCellValue('B' . $rowNumber, $row['ad']);
    $sheet->setCellValue('C' . $rowNumber, $row['soyad']);
    $sheet->setCellValue('D' . $rowNumber, $row['telefon']);
    $sheet->setCellValue('E' . $rowNumber, $row['dogum_tarihi']);
    $sheet->setCellValue('F' . $rowNumber, $row['egitim_baslik']);
    $sheet->setCellValue('G' . $rowNumber, $row['basvuru_tarihi']);
    $rowNumber++;
}

// Dosyayı kullanıcıya indir
$filename = 'basvurular_' . date('Y-m-d') . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
