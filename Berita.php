<?php
require_once 'koneksi.php';

class Berita
{
    public function uploadFotoBerita($fileInputName)
    {
        $targetDirectory = "uploads/berita/";
        $targetFile = $targetDirectory . basename($_FILES[$fileInputName]["name"]);

        if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFile)) {
            return basename($_FILES[$fileInputName]["name"]);
        } else {
            return false;
        }
    }

    public function tambahBerita($data)
    {
        global $conn;

        $judul = mysqli_real_escape_string($conn, $data['judul']);
        $isi = mysqli_real_escape_string($conn, $data['isi']);
        $tanggal_publikasi = mysqli_real_escape_string($conn, $data['tanggal_publikasi']);
        $penulis = mysqli_real_escape_string($conn, $data['penulis']);
        $sumber = mysqli_real_escape_string($conn, $data['sumber']);

        // Periksa apakah file foto berita diupload
        if (isset($data['foto_berita']['name']) && !empty($data['foto_berita']['name'])) {
            $foto_berita = $this->uploadFotoBerita('foto_berita');

            // Memasukkan nama file foto ke dalam database
            $sql = "INSERT INTO berita (judul, isi, tanggal_publikasi, penulis, sumber, foto_berita) 
                    VALUES ('$judul', '$isi', '$tanggal_publikasi', '$penulis', '$sumber', '$foto_berita')";
        } else {
            // Jika tidak, gunakan foto default
            $foto_berita = "default.jpg";
            $sql = "INSERT INTO berita (judul, isi, tanggal_publikasi, penulis, sumber, foto_berita) 
                    VALUES ('$judul', '$isi', '$tanggal_publikasi', '$penulis', '$sumber', '$foto_berita')";
        }

        return $conn->query($sql);
    }

    public function ambilBerita($id)
    {
        global $conn;

        $id = mysqli_real_escape_string($conn, $id);

        $sql = "SELECT * FROM berita WHERE id = $id";
        $result = $conn->query($sql);

        return $result->fetch_assoc();
    }

    public function ambilSemuaBerita()
    {
        global $conn;

        $sql = "SELECT * FROM berita";
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

    public function updateBerita($id, $data)
    {
        global $conn;

        // Menghindari SQL injection dengan membersihkan ID dan data yang diterima
        $id = mysqli_real_escape_string($conn, $id);
        $judul = mysqli_real_escape_string($conn, $data['judul']);
        $isi = mysqli_real_escape_string($conn, $data['isi']);
        $tanggal_publikasi = mysqli_real_escape_string($conn, $data['tanggal_publikasi']);
        $penulis = mysqli_real_escape_string($conn, $data['penulis']);
        $sumber = mysqli_real_escape_string($conn, $data['sumber']);

        // Ambil informasi berita sebelum diupdate
        $beritaSebelumDiupdate = $this->ambilBerita($id);

        // Cek apakah file foto berita diupload
        if (isset($data['foto_berita']['name']) && !empty($data['foto_berita']['name'])) {
            // Hapus foto lama jika tidak menggunakan foto default
            if ($beritaSebelumDiupdate['foto_berita'] != "default.jpg") {
                $this->hapusFotoBerita($beritaSebelumDiupdate['foto_berita']);
            }
            // Upload foto baru dan dapatkan nama file baru
            $foto_berita = $this->uploadFotoBerita('foto_berita');

            // Update data berita termasuk foto baru
            $sql = "UPDATE berita 
                    SET judul='$judul', isi='$isi', tanggal_publikasi='$tanggal_publikasi',
                        penulis='$penulis', sumber='$sumber', foto_berita='$foto_berita'
                    WHERE id=$id";
        } else {
            // Jika tidak ada foto baru, update data tanpa mengubah foto
            $sql = "UPDATE berita 
                    SET judul='$judul', isi='$isi', tanggal_publikasi='$tanggal_publikasi',
                        penulis='$penulis', sumber='$sumber'
                    WHERE id=$id";
        }

        // Eksekusi query update dan mengembalikan hasilnya (true/false)
        return $conn->query($sql);
    }

    public function hapusBerita($id)
    {
        global $conn;

        $id = mysqli_real_escape_string($conn, $id);

        // Ambil informasi berita sebelum dihapus
        $beritaSebelumDihapus = $this->ambilBerita($id);

        $sql = "DELETE FROM berita WHERE id = $id";

        // Hapus berita dari database
        if ($conn->query($sql)) {
            // Jika penghapusan berhasil, hapus juga foto jika ada
            $this->hapusFotoBerita($beritaSebelumDihapus['foto_berita']);
            return true;
        } else {
            return false;
        }
    }

    private function hapusFotoBerita($fileName)
    {
        $filePath = 'uploads/berita/' . $fileName;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
?>
