<?php
// Mengimpor file koneksi.php yang berisi koneksi ke database
require_once 'koneksi.php';

class Properti
{
    // Fungsi untuk mengupload foto properti ke server.
    public function uploadFoto($fileInputName)
    {
        // Direktori tempat menyimpan foto properti
        $targetDirectory = "uploads/properti/";
         // Path lengkap ke file target
        $targetFile = $targetDirectory . basename($_FILES[$fileInputName]["name"]);
        // Pindahkan file yang diupload ke direktori target
        if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFile)) {
             // Jika berhasil, kembalikan nama file
            return basename($_FILES[$fileInputName]["name"]);
        } else {
            // Jika gagal, kembalikan false
            return false;
        }
    }
    // Fungsi untuk menambahkan data properti baru ke dalam database.
    public function tambahProperti($data)
    {
        global $conn;
        // Escape semua input untuk mencegah SQL Injection
        $nama = mysqli_real_escape_string($conn, $data['nama']);
        $status = mysqli_real_escape_string($conn, $data['status']);
        $lokasi = mysqli_real_escape_string($conn, $data['lokasi']);
        $kamar_tidur = mysqli_real_escape_string($conn, $data['kamar_tidur']);
        $kamar_mandi = mysqli_real_escape_string($conn, $data['kamar_mandi']);
        $ukuran_bangunan = mysqli_real_escape_string($conn, $data['ukuran_bangunan']);
        $harga = mysqli_real_escape_string($conn, $data['harga']);
        $id_referensi = mysqli_real_escape_string($conn, $data['id_referensi']);
        $daerah = mysqli_real_escape_string($conn, $data['daerah']);
        $jenis_daftar = mysqli_real_escape_string($conn, $data['jenis_daftar']);
        $jenis_properti = mysqli_real_escape_string($conn, $data['jenis_properti']);
        $luas_tanah = mysqli_real_escape_string($conn, $data['luas_tanah']);
        $tahun_dibangun = mysqli_real_escape_string($conn, $data['tahun_dibangun']);
        $deskripsi = mysqli_real_escape_string($conn, $data['deskripsi']);
        $id_user = mysqli_real_escape_string($conn, $data['id_user']);
        // Check apakah foto diupload
        if (isset($data['foto']['name']) && !empty($data['foto']['name'])) {
            // Upload foto dan dapatkan nama file
            $foto = $this->uploadFoto('foto');
             // Query untuk menyimpan data properti dengan foto
            $sql = "INSERT INTO properti (nama, status, lokasi, kamar_tidur, kamar_mandi, ukuran_bangunan, harga, id_referensi, daerah, jenis_daftar, jenis_properti, luas_tanah, tahun_dibangun, deskripsi, id_user, foto) 
                    VALUES ('$nama', '$status', '$lokasi', '$kamar_tidur', '$kamar_mandi', '$ukuran_bangunan', '$harga', '$id_referensi', '$daerah', '$jenis_daftar', '$jenis_properti', '$luas_tanah', '$tahun_dibangun', '$deskripsi', '$id_user', '$foto')";
        } else {
            // Jika tidak ada foto, gunakan foto default
            $foto = "default.jpg";
            // Query untuk menyimpan data properti tanpa foto
            $sql = "INSERT INTO properti (nama, status, lokasi, kamar_tidur, kamar_mandi, ukuran_bangunan, harga, id_referensi, daerah, jenis_daftar, jenis_properti, luas_tanah, tahun_dibangun, deskripsi, id_user, foto) 
                    VALUES ('$nama', '$status', '$lokasi', '$kamar_tidur', '$kamar_mandi', '$ukuran_bangunan', '$harga', '$id_referensi', '$daerah', '$jenis_daftar', '$jenis_properti', '$luas_tanah', '$tahun_dibangun', '$deskripsi', '$id_user', '$foto')";
        }
        // Eksekusi query dan kembalikan hasilnya (true jika berhasil, false jika gagal)
        return $conn->query($sql);
    }
    // Fungsi untuk mengambil data properti berdasarkan ID.
    public function ambilProperti($id)
    {
        global $conn;
        // Escape ID untuk mencegah SQL Injection
        $id = mysqli_real_escape_string($conn, $id);
        // Query untuk mengambil data properti berdasarkan ID
        $sql = "SELECT * FROM properti WHERE id = $id";
        $result = $conn->query($sql);
        // Mengembalikan hasil query berupa data properti
        return $result->fetch_assoc();
    }
    //Fungsi untuk mengambil semua data properti dari database.
    public function ambilSemuaProperti()
    {
        global $conn;
        // Query untuk mengambil semua data properti
        $sql = "SELECT * FROM properti";
        $result = $conn->query($sql);
        // Inisialisasi array untuk menyimpan data properti
        $data = [];
        // Inisialisasi counter dan nomor tabel
        $counter = 0;
        $tableNumber = 1;

        while ($row = $result->fetch_assoc()) {
            $data[$tableNumber][] = $row;
            $counter++;

            if ($counter == 10) {
                $counter = 0;
                $tableNumber++;
            }
        }

        return $data;
    }
    //Fungsi untuk memperbarui data properti berdasarkan ID.
    public function updateProperti($id, $data)
    {
        global $conn;
        // Escape ID dan semua data untuk mencegah SQL Injection
        $id = mysqli_real_escape_string($conn, $id);
        $nama = mysqli_real_escape_string($conn, $data['nama']);
        $status = mysqli_real_escape_string($conn, $data['status']);
        $lokasi = mysqli_real_escape_string($conn, $data['lokasi']);
        $kamar_tidur = mysqli_real_escape_string($conn, $data['kamar_tidur']);
        $kamar_mandi = mysqli_real_escape_string($conn, $data['kamar_mandi']);
        $ukuran_bangunan = mysqli_real_escape_string($conn, $data['ukuran_bangunan']);
        $harga = mysqli_real_escape_string($conn, $data['harga']);
        $id_referensi = mysqli_real_escape_string($conn, $data['id_referensi']);
        $daerah = mysqli_real_escape_string($conn, $data['daerah']);
        $jenis_daftar = mysqli_real_escape_string($conn, $data['jenis_daftar']);
        $jenis_properti = mysqli_real_escape_string($conn, $data['jenis_properti']);
        $luas_tanah = mysqli_real_escape_string($conn, $data['luas_tanah']);
        $tahun_dibangun = mysqli_real_escape_string($conn, $data['tahun_dibangun']);
        $deskripsi = mysqli_real_escape_string($conn, $data['deskripsi']);
        $id_user = mysqli_real_escape_string($conn, $data['id_user']);
        // Ambil data properti sebelum diupdate
        $propertiSebelumDiupdate = $this->ambilProperti($id);
        // Check apakah foto diupload
        if (isset($data['foto']['name']) && !empty($data['foto']['name'])) {
            // Jika foto lama bukan default.jpg, hapus foto lama
            if ($propertiSebelumDiupdate['foto'] != "default.jpg") {
                $this->hapusFoto($propertiSebelumDiupdate['foto']);
            }
            // Upload foto baru dan dapatkan nama file
            $foto = $this->uploadFoto('foto');
            // Query untuk update data properti dengan foto baru
            $sql = "UPDATE properti 
                    SET nama='$nama', status='$status', lokasi='$lokasi', kamar_tidur='$kamar_tidur',
                        kamar_mandi='$kamar_mandi', ukuran_bangunan='$ukuran_bangunan', harga='$harga',
                        id_referensi='$id_referensi', daerah='$daerah', jenis_daftar='$jenis_daftar',
                        jenis_properti='$jenis_properti', luas_tanah='$luas_tanah', tahun_dibangun='$tahun_dibangun',
                        deskripsi='$deskripsi', id_user='$id_user', foto='$foto'
                    WHERE id=$id";
        } else {
            // Jika tidak ada foto baru, update data tanpa mengubah foto
            $sql = "UPDATE properti 
                    SET nama='$nama', status='$status', lokasi='$lokasi', kamar_tidur='$kamar_tidur',
                        kamar_mandi='$kamar_mandi', ukuran_bangunan='$ukuran_bangunan', harga='$harga',
                        id_referensi='$id_referensi', daerah='$daerah', jenis_daftar='$jenis_daftar',
                        jenis_properti='$jenis_properti', luas_tanah='$luas_tanah', tahun_dibangun='$tahun_dibangun',
                        deskripsi='$deskripsi', id_user='$id_user'
                    WHERE id=$id";
        }
        // Eksekusi query update dan mengembalikan hasilnya (true/false)
        return $conn->query($sql);
    }
    //Fungsi untuk menghapus data properti dari database berdasarkan ID.
    public function hapusProperti($id)
    {
        global $conn;
        // Escape ID untuk mencegah SQL Injection
        $id = mysqli_real_escape_string($conn, $id);
        // Ambil data properti sebelum dihapus
        $propertiSebelumDihapus = $this->ambilProperti($id);
        // Query untuk menghapus data properti berdasarkan ID
        $sql = "DELETE FROM properti WHERE id = $id";
        // Jika query berhasil dijalankan, hapus foto properti yang terkait
        if ($conn->query($sql)) {
            $this->hapusFoto($propertiSebelumDihapus['foto']);
            return true;
        } else {
            return false;
        }
    }
    //Fungsi untuk menghapus foto properti dari server.
    private function hapusFoto($fileName)
    {
        // Path lengkap ke file foto properti yang akan dihapus
        $filePath = 'uploads/properti/' . $fileName;
        // Hapus file jika ada
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
?>
