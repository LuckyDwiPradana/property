<?php
// Memasukkan file koneksi.php untuk menghubungkan ke database
require_once 'koneksi.php';

// Mendefinisikan kelas Agen
class Agen
{
    // Fungsi untuk mengupload gambar
    public function uploadGambar($fileInputName)
    {
        // Menentukan direktori target untuk menyimpan gambar yang diupload
        $targetDirectory = "uploads/agen/";
        // Menentukan path target untuk file yang akan diupload
        $targetFile = $targetDirectory . basename($_FILES[$fileInputName]["name"]);

        // Memindahkan file yang diupload ke direktori target
        if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFile)) {
            // Mengembalikan nama file yang diupload
            return basename($_FILES[$fileInputName]["name"]);
        } else {
            // Mengembalikan false jika gagal mengupload file
            return false;
        }
    }

    // Fungsi untuk menambahkan data agen baru ke database
    public function tambahAgen($data)
    {
        global $conn;

        // Membersihkan data dari potensi serangan SQL injection
        $nama_agen = mysqli_real_escape_string($conn, $data['nama_agen']);
        $alamat = mysqli_real_escape_string($conn, $data['alamat']);
        $nomor_telepon = mysqli_real_escape_string($conn, $data['nomor_telepon']);
        $email = mysqli_real_escape_string($conn, $data['email']);
        $facebook = mysqli_real_escape_string($conn, $data['facebook']);
        $twitter = mysqli_real_escape_string($conn, $data['twitter']);
        $instagram = mysqli_real_escape_string($conn, $data['instagram']);
        $password = password_hash($data['password'], PASSWORD_DEFAULT); // Melakukan hashing pada password

        // Periksa apakah file gambar diupload
        if (isset($data['foto_agen']['name']) && !empty($data['foto_agen']['name'])) {
            // Jika ada, upload gambar dan simpan nama file gambar ke dalam database
            $foto_agen = $this->uploadGambar('foto_agen');
            $sql = "INSERT INTO agen (nama_agen, alamat, nomor_telepon, email, twitter, facebook, instagram, password, foto_agen) 
                    VALUES ('$nama_agen', '$alamat', '$nomor_telepon', '$email','$twitter', '$facebook', '$instagram', '$password', '$foto_agen')";
        } else {
            // Jika tidak, gunakan foto default dan simpan nama file default ke dalam database
            $foto_agen = "default.jpg";
            $sql = "INSERT INTO agen (nama_agen, alamat, nomor_telepon, email, twitter, facebook, instagram, password, foto_agen) 
                    VALUES ('$nama_agen', '$alamat', '$nomor_telepon', '$email','$twitter', '$facebook', '$instagram', '$password', '$foto_agen')";
        }

        // Eksekusi query untuk menambahkan agen baru ke dalam database
        return $conn->query($sql);
    }

    // Fungsi untuk mengambil informasi agen berdasarkan ID
    public function ambilAgen($id)
    {
        global $conn;

        // Membersihkan ID dari potensi serangan SQL injection
        $id = mysqli_real_escape_string($conn, $id);

        // Query untuk mengambil informasi agen berdasarkan ID
        $sql = "SELECT * FROM agen WHERE id = $id";
        $result = $conn->query($sql);

        // Mengembalikan hasil query dalam bentuk array asosiatif
        return $result->fetch_assoc();
    }

    // Fungsi untuk mengambil semua data agen dari database
    public function ambilSemuaAgen()
    {
        global $conn;

        // Query untuk mengambil semua data agen
        $sql = "SELECT * FROM agen";
        $result = $conn->query($sql);

        // Mengembalikan hasil query dalam bentuk array
        $data = [];
        $counter = 0;
        $tableNumber = 1;

        while ($row = $result->fetch_assoc()) {
            $data[$tableNumber][] = $row;
            $counter++;

            // Jika jumlah data mencapai batas tertentu, buat tabel baru
            if ($counter == 10) {
                $counter = 0;
                $tableNumber++;
            }
        }

        return $data;
    }

    // Fungsi untuk memperbarui data agen berdasarkan ID
    public function updateAgen($id, $data)
    {
        global $conn;

        // Membersihkan ID dan data dari potensi serangan SQL injection
        $id = mysqli_real_escape_string($conn, $id);
        $nama_agen = mysqli_real_escape_string($conn, $data['nama_agen']);
        $alamat = mysqli_real_escape_string($conn, $data['alamat']);
        $nomor_telepon = mysqli_real_escape_string($conn, $data['nomor_telepon']);
        $email = mysqli_real_escape_string($conn, $data['email']);
        $facebook = mysqli_real_escape_string($conn, $data['facebook']);
        $twitter = mysqli_real_escape_string($conn, $data['twitter']);
        $instagram = mysqli_real_escape_string($conn, $data['instagram']);

        // Mengambil informasi agen sebelum diupdate
        $agenSebelumDiupdate = $this->ambilAgen($id);

        // Memeriksa apakah file foto diupload
        if (isset($data['foto_agen']['name']) && !empty($data['foto_agen']['name'])) {
            // Menghapus foto lama jika tidak menggunakan foto default
            if ($agenSebelumDiupdate['foto_agen'] != "default.jpg") {
                $this->hapusFoto($agenSebelumDiupdate['foto_agen']);
            }
            // Mengupload foto baru dan mendapatkan nama file baru
            $foto_agen = $this->uploadGambar('foto_agen');

            // Update data agen termasuk foto baru
            $sql = "UPDATE agen 
                    SET nama_agen='$nama_agen', alamat='$alamat', nomor_telepon='$nomor_telepon',
                        email='$email', facebook='$facebook', twitter='$twitter', instagram='$instagram',
                        foto_agen='$foto_agen'
                    WHERE id=$id";
        } else {
            // Jika tidak ada foto baru, update data tanpa mengubah foto
            $sql = "UPDATE agen 
                    SET nama_agen='$nama_agen', alamat='$alamat', nomor_telepon='$nomor_telepon',
                        email='$email', facebook='$facebook', twitter='$twitter', instagram='$instagram'
                    WHERE id=$id";
        }

        // Eksekusi query update dan mengembalikan hasilnya (true/false)
        return $conn->query($sql);
    }

    // Fungsi untuk menghapus data agen berdasarkan ID
    public function hapusAgen($id)
    {
        global $conn;

        // Membersihkan ID dari potensi serangan SQL injection
        $id = mysqli_real_escape_string($conn, $id);

        // Mengambil informasi agen sebelum dihapus
        $agenSebelumDihapus = $this->ambilAgen($id);

        // Query untuk menghapus agen dari database
        $sql = "DELETE FROM agen WHERE id = $id";

        // Menghapus agen dari database
        if ($conn->query($sql)) {
            // Jika penghapusan berhasil, hapus juga foto jika ada
            $this->hapusFoto($agenSebelumDihapus['foto_agen']);
            return true;
        } else {
            return false;
        }
    }

    // Fungsi untuk menghapus foto agen
    private function hapusFoto($fileName)
    {
        // Mendefinisikan path file foto agen
        $filePath = 'uploads/agen/' . $fileName;
        // Menghapus file foto agen jika ada
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
?>
