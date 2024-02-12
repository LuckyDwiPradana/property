<?php

require_once 'koneksi.php';

class Testimoni
{
    public function uploadFotoTestimoni($fileInputName)
    {
        $targetDirectory = "uploads/testimoni/";
        $targetFile = $targetDirectory . basename($_FILES[$fileInputName]["name"]);

        if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFile)) {
            return basename($_FILES[$fileInputName]["name"]);
        } else {
            return false;
        }
    }

    public function tambahTestimoni($data)
    {
        global $conn;

        $nama_pelanggan = mysqli_real_escape_string($conn, $data['nama_pelanggan']);
        $testimoni = mysqli_real_escape_string($conn, $data['testimoni']);
        $rating = mysqli_real_escape_string($conn, $data['rating']);

        // Periksa apakah file foto testimoni diupload
        if (isset($data['foto_testimoni']['name']) && !empty($data['foto_testimoni']['name'])) {
            $foto_testimoni = $this->uploadFotoTestimoni('foto_testimoni');

            // Memasukkan nama file foto ke dalam database
            $sql = "INSERT INTO testimoni (nama_pelanggan, testimoni, rating, foto_testimoni) 
                    VALUES ('$nama_pelanggan', '$testimoni', $rating, '$foto_testimoni')";
        } else {
            // Jika tidak, gunakan foto default
            $foto_testimoni = "default.jpg";
            $sql = "INSERT INTO testimoni (nama_pelanggan, testimoni, rating, foto_testimoni) 
                    VALUES ('$nama_pelanggan', '$testimoni', $rating, '$foto_testimoni')";
        }

        return $conn->query($sql);
    }

    public function ambilTestimoni($id)
    {
        global $conn;

        $id = mysqli_real_escape_string($conn, $id);

        $sql = "SELECT * FROM testimoni WHERE id = $id";
        $result = $conn->query($sql);

        return $result->fetch_assoc();
    }

    public function ambilSemuaTestimoni()
    {
        global $conn;

        $sql = "SELECT * FROM testimoni";
        $result = $conn->query($sql);

        $data = [];
        $counter = 0;
        $tableNumber = 1;

        while ($row = $result->fetch_assoc()) {
            $data[$tableNumber][] = $row;
            $counter++;

            // Jika jumlah data mencapai batas (contoh: 10), buat tabel baru
            if ($counter == 10) {
                $counter = 0;
                $tableNumber++;
            }
        }

        return $data;
    }

    public function updateTestimoni($id, $data)
    {
        global $conn;

        // Menghindari SQL injection dengan membersihkan ID dan data yang diterima
        $id = mysqli_real_escape_string($conn, $id);
        $nama_pelanggan = mysqli_real_escape_string($conn, $data['nama_pelanggan']);
        $testimoni = mysqli_real_escape_string($conn, $data['testimoni']);
        $rating = mysqli_real_escape_string($conn, $data['rating']);

        // Ambil informasi testimoni sebelum diupdate
        $testimoniSebelumDiupdate = $this->ambilTestimoni($id);

        // Cek apakah file foto testimoni diupload
        if (isset($data['foto_testimoni']['name']) && !empty($data['foto_testimoni']['name'])) {
            // Hapus foto lama jika tidak menggunakan foto default
            if ($testimoniSebelumDiupdate['foto_testimoni'] != "default.jpg") {
                $this->hapusFotoTestimoni($testimoniSebelumDiupdate['foto_testimoni']);
            }
            // Upload foto baru dan dapatkan nama file baru
            $foto_testimoni = $this->uploadFotoTestimoni('foto_testimoni');

            // Update data testimoni termasuk foto baru
            $sql = "UPDATE testimoni 
                    SET nama_pelanggan='$nama_pelanggan', testimoni='$testimoni', rating=$rating, foto_testimoni='$foto_testimoni'
                    WHERE id=$id";
        } else {
            // Jika tidak ada foto baru, update data tanpa mengubah foto
            $sql = "UPDATE testimoni 
                    SET nama_pelanggan='$nama_pelanggan', testimoni='$testimoni', rating=$rating
                    WHERE id=$id";
        }

        // Eksekusi query update dan mengembalikan hasilnya (true/false)
        return $conn->query($sql);
    }

    public function hapusTestimoni($id)
    {
        global $conn;

        $id = mysqli_real_escape_string($conn, $id);

        // Ambil informasi testimoni sebelum dihapus
        $testimoniSebelumDihapus = $this->ambilTestimoni($id);

        $sql = "DELETE FROM testimoni WHERE id = $id";

        // Hapus testimoni dari database
        if ($conn->query($sql)) {
            // Jika penghapusan berhasil, hapus juga foto jika ada
            $this->hapusFotoTestimoni($testimoniSebelumDihapus['foto_testimoni']);
            return true;
        } else {
            return false;
        }
    }

    private function hapusFotoTestimoni($fileName)
    {
        $filePath = 'uploads/testimoni/' . $fileName;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}

?>
