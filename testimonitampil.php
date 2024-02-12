<?php
require("koneksi.php");
require_once 'Testimoni.php';
$testimoniObj = new Testimoni();
$data = $testimoniObj->ambilSemuaTestimoni();
$no = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT. Total Property - Data Testimoni</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">

    <link rel="shortcut icon" href="./assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" href="./assets/compiled/css/table-datatable.css">
    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
    <style>
        .rating {
            font-size: 24px;
            cursor: pointer;
        }

        .rating span {
            color: #ddd;
            display: inline-block;
            width: 20px;
            overflow: hidden;
        }

        .rating span:hover,
        .rating span.selected {
            color: gold;
        }
    </style>
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
                            <h3>Data Testimoni</h3>
                            <p class="text-subtitle text-muted">A sortable, searchable, paginated table without dependencies thanks to simple-datatables.</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="testimonitampil.php">Data Testimoni</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Lihat Testimoni</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                Lihat Testimoni
                            </h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Testimoni</th>
                                        <th>Rating</th>
                                        <th>Foto</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $tableNumber => $tableData) : ?>
                                        <?php foreach ($tableData as $row) : ?>
                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $row['nama_pelanggan']; ?></td>
                                                <td><?= $row['testimoni']; ?></td>
                                                <td class="rating">
                                                    <?php
                                                    $rating = isset($row['rating']) ? intval($row['rating']) : 0;
                                                    for ($i = 1; $i <= 5; $i++) {
                                                        $class = ($i <= $rating) ? 'selected' : '';
                                                        echo '<span class="' . $class . '">&#9733;</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php if (isset($row['foto_testimoni'])) : ?>
                                                        <!-- Menampilkan gambar berita dengan Lightbox2 -->
                                                        <a href="uploads/testimoni/<?= $row['foto_testimoni']; ?>" data-lightbox="testimoni" data-title="Foto Testimoni">
                                                            <img class="hover-shadow" src="uploads/testimoni/<?= $row['foto_testimoni']; ?>" alt="Foto Testimoni" style="width: 100px; height: 50px;">
                                                        </a>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        <a href="testimoniedit.php?id=<?= isset($row['id']) ? $row['id'] : ''; ?>" class="btn btn-info">
                                                            <i class="mdi mdi-table-edit"></i> Edit
                                                        </a>
                                                        <a href="testimonihapus.php?id=<?= isset($row['id']) ? $row['id'] : ''; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                                                            