<?php
// Menggunakan koneksi.php yang sudah ada
require("koneksi.php");

require_once 'Properti.php';
$properti = new Properti();
$data = $properti->ambilSemuaProperti();
$no = 1;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT. Total Property</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">

    <link rel="shortcut icon" href="./assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS41LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICAgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIKICAgZXhpZjpQaXhlbFhEaW1lbnNpb249IjMzIgogICBleGlmOlBpeGVsWURpbWVuc2lvbj0iMzQiCiAgIExhYmVsTWVkX1NpemVmTW9kZXM6W1hZWiAiNE9UJydFTkNSWlRTJyIgLiBtb3ZlbWVudGFyKGh0dHA6Ly9ucy5hZG9iZS5jb20vdjMvb3JnLzEuMC8iXSwgInRyYW5zcGFyZW50Ijp0cnVlLCBbdHJhbnNmZXItbGVmdC1TaXplbU9iamVjdC0zMTQ0MDE2My1iMSJdLCB0aHVtYm5haWw9IjAiCiAgIHN0eWxlPSJzdHJva2Utd2lkdGg6MXB4IgogICBkYXRhLWFjdGlvbj0iMSIKICAgdGlmZjpJbWFnZVdpZHRoPSIzMyIKICAgdGlmZjpJbWFn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" type="image/png">

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
                            <h3>Data Properti</h3>
                            <p class="text-subtitle text-muted">A sortable, searchable, paginated table without dependencies thanks to simple-datatables.</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="propertitampil.php">Data Properti</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Lihat Properti</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                Lihat Properti
                            </h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <!-- ... Bagian Header Tabel ... -->
<thead>
    <tr>
        <th>No</th>
        <th>Nama Properti</th>
        <th>Status</th>
        <th>Lokasi</th>
        <th>Kamar Tidur</th>
        <th>Kamar Mandi</th>
        <th>Ukuran Bangunan</th>
        <th>Harga</th>
        <th>ID Referensi</th>
        <th>Daerah</th>
        <th>Jenis Daftar</th>
        <th>Jenis Properti</th>
        <th>Luas Tanah</th>
        <th>Tahun Dibangun</th>
        <th>Deskripsi</th>
        <th>Foto</th>
        <th>ID User</th>
        <th>Aksi</th>
    </tr>
</thead>

<!-- ... Bagian Data Tabel ... -->
<tbody>
    <?php foreach ($data as $tableNumber => $tableData) : ?>
        <?php foreach ($tableData as $row) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $row['nama']; ?></td>
                <td><?= $row['status']; ?></td>
                <td><?= $row['lokasi']; ?></td>
                <td><?= $row['kamar_tidur']; ?></td>
                <td><?= $row['kamar_mandi']; ?></td>
                <td><?= $row['ukuran_bangunan']; ?></td>
                <td><?= $row['harga']; ?></td>
                <td><?= $row['id_referensi']; ?></td>
                <td><?= $row['daerah']; ?></td>
                <td><?= $row['jenis_daftar']; ?></td>
                <td><?= $row['jenis_properti']; ?></td>
                <td><?= $row['luas_tanah']; ?></td>
                <td><?= $row['tahun_dibangun']; ?></td>
                <td><?= $row['deskripsi']; ?></td>
                <td>
                    <!-- Menampilkan gambar properti dengan Lightbox2 -->
                    <a href="uploads/properti/<?= $row['foto']; ?>" data-lightbox="properti" data-title="Foto Properti">
                        <img src="uploads/properti/<?= $row['foto']; ?>" alt="Foto Properti" style="width: 100px; height: 50px;">
                    </a>
                </td>
                <td><?= $row['id_user']; ?></td>
                <td>
                    <div class="action-buttons">
                        <a href="propertiedit.php?id=<?= $row['id']; ?>" class="btn btn-info">
                            <i class="mdi mdi-table-edit"></i> Edit
                        </a>
                        <a href="propertihapus.php?id=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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