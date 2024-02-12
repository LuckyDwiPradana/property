<?php
require("koneksi.php");

require_once 'Agen.php';
$agen = new Agen();
$dataAgen = $agen->ambilSemuaAgen();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan melalui formulir
    $nama = $_POST['nama'];
    $status = $_POST['status'];
    $lokasi = $_POST['lokasi'];
    $kamar_tidur = $_POST['kamar_tidur'];
    $kamar_mandi = $_POST['kamar_mandi'];
    $ukuran_bangunan = $_POST['ukuran_bangunan'];
    $harga = $_POST['harga'];
    $id_referensi = $_POST['id_referensi'];
    $daerah = $_POST['daerah'];
    $jenis_daftar = $_POST['jenis_daftar'];
    $jenis_properti = $_POST['jenis_properti'];
    $luas_tanah = $_POST['luas_tanah'];
    $tahun_dibangun = $_POST['tahun_dibangun'];
    $deskripsi = $_POST['deskripsi'];
    $id_user = $_POST['id_user'];

    // Proses upload foto
    $foto = $_FILES['foto']['name'];
    $targetDirectory = "uploads/properti/";
    $targetFile = $targetDirectory . basename($foto);

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile)) {
        // Jika upload foto berhasil, masukkan data ke dalam database
        $sql = "INSERT INTO properti (nama, status, lokasi, kamar_tidur, kamar_mandi, ukuran_bangunan, harga, id_referensi, daerah, jenis_daftar, jenis_properti, luas_tanah, tahun_dibangun, deskripsi, foto, id_user) 
                VALUES ('$nama', '$status', '$lokasi', $kamar_tidur, $kamar_mandi, $ukuran_bangunan, $harga, '$id_referensi', '$daerah', '$jenis_daftar', '$jenis_properti', $luas_tanah, $tahun_dibangun, '$deskripsi', '$foto', $id_user)";

        if ($conn->query($sql) === TRUE) {
            header("Location: propertitampil.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT. Total Property - Tambah Properti</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <link rel="stylesheet" href="./assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" href="./assets/compiled/css/table-datatable.css">
    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <?php include("sidebar_admin.php"); ?>
            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Tambah Properti</h3>
                            <p class="text-subtitle text-muted">Formulir tambah data properti.</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="propertitampil.php">Data Properti</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Tambah Properti</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                Formulir Tambah Properti
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="propertitambah.php" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="nama" class="form-label">Nama Properti</label>
                                        <input type="text" class="form-control" id="nama" name="nama" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="status" class="form-label">Status</label>
                                        <input type="text" class="form-control" id="status" name="status" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="lokasi" class="form-label">Lokasi</label>
                                        <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="kamar_tidur" class="form-label">Kamar Tidur</label>
                                        <input type="number" class="form-control" id="kamar_tidur" name="kamar_tidur" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="kamar_mandi" class="form-label">Kamar Mandi</label>
                                        <input type="number" class="form-control" id="kamar_mandi" name="kamar_mandi" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="ukuran_bangunan" class="form-label">Ukuran Bangunan</label>
                                        <input type="number" class="form-control" id="ukuran_bangunan" name="ukuran_bangunan" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="harga" class="form-label">Harga</label>
                                        <input type="number" class="form-control" id="harga" name="harga" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="id_referensi" class="form-label">ID Referensi</label>
                                        <input type="text" class="form-control" id="id_referensi" name="id_referensi" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="daerah" class="form-label">Daerah</label>
                                        <input type="text" class="form-control" id="daerah" name="daerah" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="jenis_daftar" class="form-label">Jenis Daftar</label>
                                        <input type="text" class="form-control" id="jenis_daftar" name="jenis_daftar" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="jenis_properti" class="form-label">Jenis Properti</label>
                                        <input type="text" class="form-control" id="jenis_properti" name="jenis_properti" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="luas_tanah" class="form-label">Luas Tanah</label>
                                        <input type="number" class="form-control" id="luas_tanah" name="luas_tanah" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="tahun_dibangun" class="form-label">Tahun Dibangun</label>
                                        <input type="number" class="form-control" id="tahun_dibangun" name="tahun_dibangun" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                                    </div>
                                </div>
                                <!-- Pilih Agen -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="id_user" class="form-label">Pilih Agen</label>
                                        <select class="form-select" id="id_user" name="id_user" required>
                                            <?php foreach ($dataAgen as $tableNumber => $tableData) : ?>
                                                <?php foreach ($tableData as $row) : ?>
                                                    <option value="<?= $row['id']; ?>"><?= $row['nama_agen']; ?></option>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="foto" class="form-label">Foto Properti</label>
                                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Tambah Properti</button>
                            </form>
                        </div>
                    </div>
                </section>
            </div>

           <?php include("footer_admin.php"); ?>
        </div>
    </div>
    <script src="assets/static/js/components/dark.js"></script>
    <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/compiled/js/app.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script src="assets/static/js/pages/simple-datatables.js"></script>
</body>

</html>
