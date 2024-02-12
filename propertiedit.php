<?php
require("koneksi.php");
require_once 'Properti.php'; // Sesuaikan dengan lokasi file Properti.php
require_once 'Agen.php';

$properti = new Properti();
$agen = new Agen();
$dataAgen = $agen->ambilSemuaAgen();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang dikirimkan melalui formulir
    $id = $_POST['id']; // Sesuaikan dengan inputan id_properti pada formulir
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

    

    // Memperbarui data properti
    $data = [
        'nama' => $nama,
        'status' => $status,
        'lokasi' => $lokasi,
        'kamar_tidur' => $kamar_tidur,
        'kamar_mandi' => $kamar_mandi,
        'ukuran_bangunan' => $ukuran_bangunan,
        'harga' => $harga,
        'id_referensi' => $id_referensi,
        'daerah' => $daerah,
        'jenis_daftar' => $jenis_daftar,
        'jenis_properti' => $jenis_properti,
        'luas_tanah' => $luas_tanah,
        'tahun_dibangun' => $tahun_dibangun,
        'deskripsi' => $deskripsi,
        'id_user' => $id_user,
    ];
//jika foto diperbarui, uplod foto baru
 if (isset($_FILES['foto']['name']) && !empty($_FILES['foto']['name'])) {
    $data['foto'] = $_FILES['foto'];
}
    // Panggil fungsi updateProperti
    $result = $properti->updateProperti($id, $data);

    if ($result) {
        header("Location: propertitampil.php");
        exit();
    } else {
        echo "Error updating property.";
    }
}

// Ambil ID Properti dari parameter URL
if (isset($_GET['id'])) {
    // ID properti dari URL
    $id = $_GET['id'];
    // Membuat objek Properti baru
    $properti = new Properti();
    // Memanggil fungsi updateProperti untuk memperbarui data properti
    $properti_data = $properti->ambilProperti($id);
     // Jika data properti tidak ditemukan, cetak pesan "Property not found."
    if (!$properti_data) {
        echo "Property not found.";
        exit();
    }
    // Jika parameter URL tidak valid
} else {
    echo "Invalid URL.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT. Total Property</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
    
    <link rel="shortcut icon" href="./assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACEAAAAiCAYAAADRcLDBAAAEs2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4KPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUg
        5LjAiPgogPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4KICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgeG1sbnM6ZXhpZj0iaHR0cDovL25zLmFkb2JlLmNvbS9leGlmLzEuMC8iCiAgICB4bWxuczp0aWZmPSJodHRwOi8vbnMuYWRvYmUuY29tL3RpZmYvMS4wLyIKICAgIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIKICAgIHhtbG5zOnhtcD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLyIKICAgIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIgogICA8eG1wTU06SGlzdG9yeT4KICAgIDxyZGY6U2VxPgogICAgIDxyZGY6bGkKICAgICAgc3RFdnQ6YWN0aW9uPSJwcm9kdWNlZCIKICAgICAgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWZmaW5pdHkgRGVzaWduZXIgMS4xMC4xIgogICAgICBzdEV2dDp3aGVuPSIyMDIyLTAzLTMxVDEwOjUwOjIzKzAyOjAwIi8+CiAgICA8L3JkZjpTZXE+CiAgIDwveG1wTU06SGlzdG9yeT4KICA8L3JkZjpEZXNjcmlwdGlvbj4KIDwvcmRmOlJERj4KPC94OnhtcG1ldGE+Cjw/eHBhY2tldCBlbmQ9InIiPz5V57uAAAABgmlDQ1BzUkdCIElFQzYxOTY2LTIuMQAAKJF1kc8rRFEUxz9maORHo1hYKC9hISNGTWwsRn4VFmOUX5uZZ36oeTOv954kW2WrKLHxa8FfwFZZK0WkZClrYoOe87ypmWTO7dzzud97z+nec8ETzaiaWd4NWtYyIiNhZWZ2TvE946WZSjqoj6mmPjE1HKWkfdxR5sSbgFOr9Ll/rXoxYapQVik8oOqGJTwqPL5i6Q5vCzeo6dii8KlwpyEXFL519LjLLw6nXP5y2IhGBsFTJ6ykijhexGra0ITl5bRqmWU1fx/nJTWJ7PSUxBbxJkwijBBGYYwhBgnRQ7/MIQIE6ZIVJfK7f/MnyUmuKrPOKgZLpEhj0SnqslRPSEyKnpCRYdXp/9++msneoFu9JgwVT7b91ga+LfjetO3PQ9v+PgLvI1xkC/m5A+h7F32zoLXug38dzi4LWnwHzjeg8UGPGbFfySvuSSbh9QRqZ6H+Gqrm3Z7l9zm+h+iafNUV7O5Bu5z3L/wAdthn7QIme0YAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAJTSURBVFiF7Zi9axRBGIefEw2IdxFBRQsLWUTBaywSK4ubdSGVIY1Y6HZql8ZKCGIqwX/AYLmCgVQKfiDn7jZeEQMWfsSAHAiKqPiB5mIgELWYOW5vzc3O7niHhT/YZvY37/swM/vOzJbIqVq9uQ04CYwCI8AhYAlYAB4Dc7HnrOSJWcoJcBS4ARzQ2F4BZ2LPmTeNuykHwEWgkQGAet9QfiMZjUSt3hwD7psGTWgs9pwH1hC1enMYeA7sKwDxBqjGnvNdZzKZjqmCAKh+U1kmEwi3IEBbIsugnY5avTkEtIAtFhBrQCX2nLVehqyRqFoCAAwBh3WGLAhbgCRIYYinwLolwLqKUwwi9pxV4KUlxKKKUwxC6ZElRCPLYAJxGfhSEOCz6m8HEXvOB2CyIMSk6m8HoXQTmMkJcA2YNTHm3congOvATo3tE3A29pxbpnFzQSiQPcB55IFmFNgFfEQeahaAGZMpsIJIAZWAHcDX2HN+2cT6r39GxmvC9aPNwH5gO1BOPFuBVWAZue0vA9+A12EgjPadnhCuH1WAE8ivYAQ4ohKaagV4gvxi5oG7YSA2vApsCOH60WngKrA3R9IsvQUuhIGY00K4flQG7gHH/mLytB4C42EgfrQb0mV7us8AAMeBS8mGNMR4nwHamtBB7B4QRNdaS0M8GxDEog7iyoAguvJ0QYSBuAOcAt71Kfl7wA8DcTvZ2KtOlJEr+ByyQtqqhTyHTIeB+ONeqi3brh+VgIN0fohUgWGggizZFTplu12yW8iy/YLOGWMpDMTPXnl+Az9vj2HERYqPAAAAAElFTkSuQmCC" type="image/png">
    
    <link rel="stylesheet" href="assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" href="./assets/compiled/css/table-datatable.css">
    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
</head>

<body>
    <div id="app">
        <div id="main">
            <header class="mb-3">
                <!-- Include your header content here -->
            </header>
            <?php include("sidebar_admin.php"); ?>
            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Edit Properti</h3>
                            <p class="text-subtitle text-muted">Formulir edit data properti.</p>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="propertitampil.php">Data Properti</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Properti</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                Formulir Edit Properti
                            </h5>
                        </div>
                        <div class="card-body">
                            <!-- Form starts here -->
                            <form method="post" action="propertiedit.php" enctype="multipart/form-data">
                                <!-- Include hidden input field for the property ID -->
                                <input type="hidden" name="id" value="<?= $properti_data; ?>">

                                <!-- Nama Properti -->
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                        <label for="nama" class="form-label">Nama Properti</label>
                                        <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($properti_data['nama']); ?>" required>
                                    </div>
                                </div> 

                                <!-- Status -->
                                <div class="col-md-6 col-12">
                                        <div class="form-group">
                                        <label for="status" class="form-label">Status</label>
                                        <input type="text" class="form-control" id="status" name="status"value="<?= htmlspecialchars($properti_data['status']); ?>" required>
                                    </div>
                                </div>

                                <!-- Lokasi -->
                                <div class="col-md-6 col-12">
                                        <div class="form-group">
                                        <label for="lokasi" class="form-label">Lokasi</label>
                                        <input type="text" class="form-control" id="lokasi" name="lokasi"value="<?= htmlspecialchars($properti_data['lokasi']); ?>" required>
                                    </div>
                                </div>

                                <!-- Kamar Tidur -->
                                <div class="col-md-6 col-12">
                                        <div class="form-group">
                                        <label for="kamar_tidur" class="form-label">Kamar Tidur</label>
                                        <input type="number" class="form-control" id="kamar_tidur" name="kamar_tidur"value="<?= htmlspecialchars($properti_data['kamar_tidur']); ?>" required>
                                    </div>
                                </div>

                                <!-- Kamar Mandi -->
                                <div class="col-md-6 col-12">
                                        <div class="form-group">
                                        <label for="kamar_mandi" class="form-label">Kamar Mandi</label>
                                        <input type="number" class="form-control" id="kamar_mandi" name="kamar_mandi"value="<?= htmlspecialchars($properti_data['kamar_mandi']); ?>" required>
                                    </div>
                                </div>

                                <!-- Ukuran Bangunan -->
                                <div class="col-md-6 col-12">
                                        <div class="form-group">
                                        <label for="ukuran_bangunan" class="form-label">Ukuran Bangunan</label>
                                        <input type="number" class="form-control" id="ukuran_bangunan" name="ukuran_bangunan"value="<?= htmlspecialchars($properti_data['ukuran_bangunan']); ?>" required>
                                    </div>
                                </div>

                                <!-- Harga -->
                                <div class="col-md-6 col-12">
                                        <div class="form-group">
                                        <label for="harga" class="form-label">Harga</label>
                                        <input type="number" class="form-control" id="harga" name="harga"value="<?= htmlspecialchars($properti_data['harga']); ?>" required>
                                    </div>
                                </div>

                                <!-- ID Referensi -->
                                <div class="col-md-6 col-12">
                                        <div class="form-group">
                                        <label for="id_referensi" class="form-label">ID Referensi</label>
                                        <input type="text" class="form-control" id="id_referensi" name="id_referensi"value="<?= htmlspecialchars($properti_data['id_referensi']); ?>" required>
                                    </div>
                                </div>

                                <!-- Daerah -->
                                <div class="col-md-6 col-12">
                                        <div class="form-group">
                                        <label for="daerah" class="form-label">Daerah</label>
                                        <input type="text" class="form-control" id="daerah" name="daerah"value="<?= htmlspecialchars($properti_data['daerah']); ?>" required>
                                    </div>
                                </div>

                                <!-- Jenis Daftar -->
                                <div class="col-md-6 col-12">
                                        <div class="form-group">
                                        <label for="jenis_daftar" class="form-label">Jenis Daftar</label>
                                        <input type="text" class="form-control" id="jenis_daftar" name="jenis_daftar"value="<?= htmlspecialchars($properti_data['jenis_daftar']); ?>" required>
                                    </div>
                                </div>

                                <!-- Jenis Properti -->
                                <div class="col-md-6 col-12">
                                        <div class="form-group">
                                        <label for="jenis_properti" class="form-label">Jenis Properti</label>
                                        <input type="text" class="form-control" id="jenis_properti" name="jenis_properti"value="<?= htmlspecialchars($properti_data['jenis_properti']); ?>" required>
                                    </div>
                                </div>

                                <!-- Luas Tanah -->
                                <div class="col-md-6 col-12">
                                        <div class="form-group">
                                        <label for="luas_tanah" class="form-label">Luas Tanah</label>
                                        <input type="number" class="form-control" id="luas_tanah" name="luas_tanah"value="<?= htmlspecialchars($properti_data['luas_tanah']); ?>" required>
                                    </div>
                                </div>

                                <!-- Tahun Dibangun -->
                                <div class="col-md-6 col-12">
                                        <div class="form-group">
                                        <label for="tahun_dibangun" class="form-label">Tahun Dibangun</label>
                                        <input type="number" class="form-control" id="tahun_dibangun" name="tahun_dibangun"value="<?= htmlspecialchars($properti_data['tahun_dibangun']); ?>" required>
                                    </div>
                                </div>

                                <!-- Deskripsi -->
                                <div class="col-md-6 col-12">
                                        <div class="form-group">
                                        <label for="deskripsi" class="form-label">Deskripsi</label>
                                        <textarea class="form-control" id="deskripsi" name="deskripsi" required><?= $properti_data['deskripsi']; ?></textarea>
                                    </div>
                                </div>

                                <!-- Pilih Agen -->
                                <div class="col-md-6 col-12">
                                        <div class="form-group">
                                        <label for="id_user" class="form-label">Pilih Agen</label>
                                        <select class="form-select" id="id_user" name="id_user" required>
                                            <?php foreach ($dataAgen as $tableNumber => $tableData) : ?>
                                                <?php foreach ($tableData as $row) : ?>
                                                    <!-- Melakukan perulangan untuk setiap baris data agen untuk membuat pilihan dropdown -->
                                                    <option value="<?= $row['id']; ?>" <?= ($row['id'] == $properti_data['id_user']) ? 'selected' : ''; ?>>
                                                    <!-- Menetapkan nilai setiap pilihan sebagai ID agen -->
                                                        <?= $row['nama_agen']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- Foto Properti -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="foto" class="form-label">Foto Properti</label>
                                        <input type="file" class="form-control" id="foto" name="foto">
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                        <input type="hidden" name="id" value="<?php echo $id; ?>" />

                            </form>
                            <!-- Form ends here -->
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
