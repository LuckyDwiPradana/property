<?php
require_once 'Berita.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form data and insert into the database
    $data = [
        'judul' => $_POST['judul'],
        'isi' => $_POST['isi'], // Add the 'isi' field
        'tanggal_publikasi' => $_POST['tanggal_publikasi'],
        'penulis' => $_POST['penulis'],
        'sumber' => $_POST['sumber'],
        'foto_berita' => $_FILES['foto_berita']
    ];

    $beritaObj = new Berita();
    $insertedId = $beritaObj->tambahBerita($data);

    if ($insertedId) {
        // Article inserted successfully
        header('Location: beritatampil.php');
        exit();
    } else {
        // Failed to insert article
        $error = 'Failed to insert article.';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT. Total Property - Tambah Berita</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    <link rel="shortcut icon" href="./assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="assets/compiled/css/app.css">
</head>

<body>
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
                            <h3>Tambah Berita</h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="beritatampil.php">Data Berita</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Tambah Berita</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="card">
                        <div class="card-body">
                            <form action="beritatambah.php" method="POST" enctype="multipart/form-data">
                                <!-- Add your form fields here -->
                                <div class="mb-3">
                                    <label for="judul" class="form-label">Judul</label>
                                    <input type="text" class="form-control" id="judul" name="judul" required>
                                </div>
                                <div class="mb-3">
                                    <label for="isi" class="form-label">Isi Berita</label>
                                    <textarea class="form-control" id="isi" name="isi" rows="5" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_publikasi" class="form-label">Tanggal Publikasi</label>
                                    <input type="date" class="form-control" id="tanggal_publikasi" name="tanggal_publikasi" required>
                                </div>
                                <div class="mb-3">
                                    <label for="penulis" class="form-label">Penulis</label>
                                    <input type="text" class="form-control" id="penulis" name="penulis" required>
                                </div>
                                <div class="mb-3">
                                    <label for="sumber" class="form-label">Sumber</label>
                                    <input type="text" class="form-control" id="sumber" name="sumber" required>
                                </div>
                                <div class="mb-3">
                                    <label for="foto_berita" class="form-label">Foto Berita</label>
                                    <input type="file" class="form-control" id="foto_berita" name="foto_berita" accept="image/*" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
            <footer>
                <?php include("footer_admin.php"); ?>
            </footer>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="assets/static/js/pages/simple-datatables.js"></script>
</body>

</html>
