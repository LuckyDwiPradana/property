<?php
require("koneksi.php");
require_once 'Berita.php';
$beritaObj = new Berita();
$data = $beritaObj->ambilSemuaBerita();
$no = 1;
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT. Total Property - Data Berita</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    
    <link rel="shortcut icon" href="./assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="assets/extensions/simple-datatables/style.css">
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
                            <h3>Data Berita</h3>
                            <p class="text-subtitle text-muted">A sortable, searchable, paginated table without dependencies thanks to simple-datatables.</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="beritatampil.php">Data Berita</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Lihat Berita</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                Lihat Berita
                            </h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Isi Berita</th>
                                        <th>Tanggal Publikasi</th>
                                        <th>Penulis</th>
                                        <th>Sumber</th>
                                        <th>Foto Berita</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($data as $tableNumber => $tableData) : ?>
                                        <?php foreach ($tableData as $row) : ?>
        <tr>
        <td><?= $no++ ?></td>
                                                <td><?= $row['judul']; ?></td>
                                                <td><?= $row['isi']; ?></td>
                                                <td><?= $row['tanggal_publikasi']; ?></td>
                                                <td><?= $row['penulis']; ?></td>
                                                <td><?= $row['sumber']; ?></td>
                                                <td>

                <?php if (isset($row['foto_berita'])) : ?>
                    <!-- Menampilkan gambar berita dengan Lightbox2 -->
                    <a href="uploads/berita/<?= $row['foto_berita']; ?>" data-lightbox="berita" data-title="Foto Berita">
                        <img class="hover-shadow" src="uploads/berita/<?= $row['foto_berita']; ?>" alt="Foto Berita" style="width: 100px; height: 50px;">
                    </a>
                <?php endif; ?>
            </td>
            <td>
                <div class="action-buttons">
                    <a href="beritaedit.php?id=<?= isset($row['id']) ? $row['id'] : ''; ?>" class="btn btn-info">
                        <i class="mdi mdi-table-edit"></i> Edit
                    </a>
                    <a href="beritahapus.php?id=<?= isset($row['id']) ? $row['id'] : ''; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                        <i class="mdi mdi-delete"></i> Delete
                    </a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php endforeach; ?>
</tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
            <footer>
                <?php include("footer_admin.php"); ?>
            </footer>
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
