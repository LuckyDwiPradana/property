<?php


require_once 'Properti.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];
    $properti = new Properti();

    // Ambil informasi agen sebelum dihapus
    $propertiInfo = $properti->ambilProperti($id);

    // Hapus foto agen dari direktori uploads
    $fotoPath = 'uploads/properti' . $propertiInfo['foto'];
    if (file_exists($fotoPath)) {
        unlink($fotoPath); // Hapus file foto
    }

    $properti->hapusProperti($id);
    header('Location: propertitampil.php');
    exit;
}


?>
