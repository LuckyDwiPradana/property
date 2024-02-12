<?php
// Memasukkan file kelas Agen.php yang berisi definisi kelas Agen
require_once 'Agen.php';
// Memeriksa apakah permintaan adalah metode GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
     // Mengambil id agen yang akan dihapus dari parameter GET
    $id = $_GET['id'];
    // Membuat instance baru dari kelas Agen
    $agen = new Agen();

    // Ambil informasi agen sebelum dihapus
    $agenInfo = $agen->ambilAgen($id);

    // Hapus foto agen dari direktori uploads
    $fotoPath = 'uploads/agen' . $agenInfo['foto_agen'];
    if (file_exists($fotoPath)) {
        unlink($fotoPath); // Hapus file foto
    }
    // Menghapus agen dari database
    $agen->hapusAgen($id);
    header('Location: agentampil.php');
    exit;
}
?>
