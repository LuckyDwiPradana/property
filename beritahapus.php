<?php
require_once 'Berita.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];
    $beritaObj = new Berita();

    // Ambil informasi berita sebelum dihapus
    $beritaInfo = $beritaObj->ambilBerita($id);

    // Hapus foto berita dari direktori uploads
    $fotoPath = 'uploads/berita' . $beritaInfo['foto_berita'];
    if (file_exists($fotoPath)) {
        unlink($fotoPath); // Hapus file foto
    }

    $beritaObj->hapusBerita($id);
    header('Location: beritatampil.php');
    exit;
}
?>
