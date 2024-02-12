<?php
require_once 'Testimoni.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];
    $testimoniObj = new Testimoni();

    // Ambil informasi testimoni sebelum dihapus
    $testimoniInfo = $testimoniObj->ambilTestimoni($id);

    // Hapus foto testimoni dari direktori uploads
    $fotoPath = 'uploads/testimoni' . $testimoniInfo['foto_testimoni'];
    if (file_exists($fotoPath)) {
        unlink($fotoPath); // Hapus file foto
    }

    $testimoniObj->hapusTestimoni($id);
    header('Location: testimonitampil.php');
    exit;
}
?>
